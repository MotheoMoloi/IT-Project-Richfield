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

    public function borrowingHistory()
    {
        $user = Auth::user();
        $borrowingHistory = Borrow::with('book')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.borrowing-history', compact('user', 'borrowingHistory'));
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
}