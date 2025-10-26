<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $booksBorrowed = Borrow::where('user_id', $user->id)
            ->where('status', 'issued')
            ->count();
        
        $overdueBooks = Borrow::where('user_id', $user->id)
            ->where('status', 'issued')
            ->where('due_date', '<', Carbon::now())
            ->count();

        $recentBorrows = Borrow::with('book')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('user.dashboard', compact('user', 'booksBorrowed', 'overdueBooks', 'recentBorrows'));
    }

    public function showProfile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    public function editProfile()
    {
        $user = Auth::user();
        return view('user.edit-profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'mobile' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'program' => 'nullable|string|max:255',
        ]);

        $user->update($validated);

        return redirect()->route('user.profile')->with('success', 'Profile updated successfully.');
    }

    public function issuedBooks()
    {
        $user = Auth::user();
        $issuedBooks = Borrow::with('book')
            ->where('user_id', $user->id)
            ->where('status', 'issued')
            ->orderBy('due_date', 'asc')
            ->get();

        $overdueCount = Borrow::where('user_id', $user->id)
            ->where('status', 'issued')
            ->where('due_date', '<', Carbon::now())
            ->count();

        return view('user.issued-books', compact('user', 'issuedBooks', 'overdueCount'));
    }


    public function searchBooks(Request $request)
    {
        $user = Auth::user();
        $query = $request->get('query');
        
        $books = Book::where('status', 'available')
            ->when($query, function($q) use ($query) {
                return $q->where('book_name', 'like', "%{$query}%")
                        ->orWhere('book_author', 'like', "%{$query}%")
                        ->orWhere('isbn', 'like', "%{$query}%")
                        ->orWhere('category', 'like', "%{$query}%");
            })
            ->paginate(12);

        return view('user.book-search', compact('user', 'books', 'query'));
    }

    public function browseBooks()
    {
        $user = Auth::user();
        $books = Book::where('status', 'available')
            ->orderBy('book_name')
            ->paginate(16);

        $categories = Book::where('status', 'available')
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');

        return view('user.book-browse', compact('user', 'books', 'categories'));
    }

    public function borrowingHistory(Request $request)
    {
        $user = Auth::user();
        
        $status = $request->get('status', 'all');
        $search = $request->get('search', '');
        
        // Start query
        $query = Borrow::with('book')
            ->where('user_id', $user->id);
        
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if ($search) {
            $query->whereHas('book', function($q) use ($search) {
                $q->where('book_name', 'like', "%{$search}%")
                  ->orWhere('book_author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
            });
        }
        
        $borrowingHistory = $query->orderBy('created_at', 'desc')
            ->paginate(10);

        // basically gets all the users stats 
        $totalBooksBorrowed = Borrow::where('user_id', $user->id)->count();
        $returnedCount = Borrow::where('user_id', $user->id)
            ->where('status', 'returned')
            ->count();
        $currentlyBorrowed = Borrow::where('user_id', $user->id)
            ->where('status', 'issued')
            ->count();
        $renewedCount = Borrow::where('user_id', $user->id)
            ->where('status', 'renewed')
            ->count();
        $overdueCount = Borrow::where('user_id', $user->id)
            ->overdue()
            ->count();
        $totalFines = Borrow::where('user_id', $user->id)
            ->sum('fine_amount');

        return view('user.borrowing-history', compact(
            'user',
            'borrowingHistory',
            'totalBooksBorrowed',
            'returnedCount',
            'currentlyBorrowed',
            'renewedCount',
            'overdueCount',
            'totalFines',
            'status',
            'search'
        ));
    }

    public function borrowBook(Request $request, $bookId)
    {
        $user = Auth::user();
        $book = Book::findOrFail($bookId);

        if (!$book->isAvailable()) {
            return redirect()->back()->with('error', 'This book is not available for borrowing.');
        }

        if ($user->hasReachedBorrowingLimit()) {
            return redirect()->back()->with('error', 'You have reached the maximum borrowing limit of 100 books.');
        }

        // checks if they already have the book
        $existingBorrow = Borrow::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->whereIn('status', ['issued', 'renewed'])
            ->exists();

        if ($existingBorrow) {
            return redirect()->back()->with('error', 'You have already borrowed this book.');
        }

        // creats the record for borrowing 
        $borrow = Borrow::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'issue_date' => Carbon::now(),
            'due_date' => Carbon::now()->addDays(14), // it sets it for 2 weeks but we can make it however long 
            'status' => 'issued',
        ]);

        $book->update(['status' => 'checked_out']);

        return redirect()->route('user.issued-books')
            ->with('success', 'Book borrowed successfully. Due date: ' . $borrow->due_date->format('M d, Y'));
    }

    public function renewBook($borrowId)
    {
        $user = Auth::user();
        $borrow = Borrow::where('id', $borrowId)
            ->where('user_id', $user->id)
            ->firstOrFail();


        $borrow->update([
            'due_date' => $borrow->due_date->addDays(7),
            'renewal_count' => $borrow->renewal_count + 1,
            'status' => 'renewed',
        ]);

        return redirect()->back()->with('success', 'Book renewed successfully. New due date: ' . $borrow->due_date->format('M d, Y'));
    }

    public function returnBook($borrowId)
    {
        $user = Auth::user();
        $borrow = Borrow::where('id', $borrowId)
            ->where('user_id', $user->id)
            ->firstOrFail();

        // updates the borrow record
        $borrow->update([
            'return_date' => Carbon::now(),
            'status' => 'returned',
            'fine_amount' => $fineAmount,
        ]);

        $book = Book::find($borrow->book_id);
        $book->update(['status' => 'available']);

        $message = 'Book returned successfully.';

        return redirect()->back()->with('success', $message);
    }
}