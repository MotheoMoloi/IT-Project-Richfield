<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Book;
use App\Models\Borrow;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $admin = Auth::guard('admin')->user();
        
        // Real statistics from database
        $userCount = User::count();
        $bookCount = Book::count();
        $issuedBookCount = Borrow::where('status', 'issued')->count();
        $overdueCount = Borrow::where('status', 'issued')
            ->where('due_date', '<', Carbon::now())
            ->count();

        $recentBorrows = Borrow::with(['user', 'book'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('admin', 'userCount', 'bookCount', 'issuedBookCount', 'overdueCount', 'recentBorrows'));
    }

    public function showProfile()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.profile', compact('admin'));
    }

    public function editProfile()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.edit-profile', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'mobile' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'office' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
        ]);

        $admin->update($validated);

        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully.');
    }

    public function manageUsers()
    {
        $admin = Auth::guard('admin')->user();
        $users = User::withCount(['borrows as active_borrows_count' => function($query) {
            $query->where('status', 'issued');
        }])->orderBy('name')->paginate(10);

        return view('admin.manage-users', compact('admin', 'users'));
    }

    public function showUser($id)
    {
        $admin = Auth::guard('admin')->user();
        $user = User::with(['borrows' => function($query) {
            $query->orderBy('created_at', 'desc');
        }, 'borrows.book'])->findOrFail($id);

        return view('admin.users.show', compact('admin', 'user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'mobile' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'program' => 'nullable|string|max:255',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.show', $user->id)->with('success', 'User updated successfully.');
    }

    public function manageBooks()
    {
        $admin = Auth::guard('admin')->user();
        $books = Book::withCount(['borrows as active_borrows_count' => function($query) {
            $query->where('status', 'issued');
        }])->orderBy('book_name')->paginate(10);

        return view('admin.manage-books', compact('admin', 'books'));
    }

    public function editBook($id)
    {
        $admin = Auth::guard('admin')->user();
        $book = Book::findOrFail($id);
        
        return view('admin.edit-book', compact('admin', 'book'));
    }

    public function updateBook(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        
        $validated = $request->validate([
            'book_name' => 'required|string|max:255',
            'book_author' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'isbn' => 'required|string|unique:books,isbn,' . $book->id,
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'price' => 'nullable|numeric|min:0',
            'status' => 'required|in:available,checked_out,reserved',
        ]);

        $book->update($validated);

        return redirect()->route('admin.books.manage')->with('success', 'Book updated successfully.');
    }

    public function deleteBook($id)
    {
        $book = Book::findOrFail($id);
        
        // Check if book is currently borrowed
        $activeBorrows = Borrow::where('book_id', $book->id)
            ->where('status', 'issued')
            ->exists();

        if ($activeBorrows) {
            return redirect()->route('admin.books.manage')->with('error', 'Cannot delete book that is currently borrowed.');
        }

        $book->delete();

        return redirect()->route('admin.books.manage')->with('success', 'Book deleted successfully.');
    }

    public function manageBorrows(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $query = Borrow::with(['user', 'book'])
            ->whereIn('status', ['issued', 'renewed', 'overdue']);

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $borrows = $query->orderBy('due_date')
            ->paginate(15);

        // Statistics
        $totalBorrows = Borrow::whereIn('status', ['issued', 'renewed'])->count();
        $overdueCount = Borrow::where('status', 'overdue')->count();
        $dueSoonCount = Borrow::where('status', 'issued')
            ->where('due_date', '<=', now()->addDays(3))
            ->where('due_date', '>', now())
            ->count();
        $renewedCount = Borrow::where('status', 'renewed')->count();
        $issuedCount = Borrow::where('status', 'issued')->count();

        // Return the renamed view
        return view('admin.view-borrows', compact(
            'admin', 
            'borrows',
            'totalBorrows',
            'overdueCount',
            'dueSoonCount',
            'renewedCount',
            'issuedCount'
        ));
    }

    public function overdueBooks()
    {
        $admin = Auth::guard('admin')->user();

        $overdueBooks = Borrow::with(['user', 'book'])
            ->where('due_date', '<', now())
            ->whereIn('status', ['issued', 'renewed'])
            ->orderBy('due_date')
            ->paginate(15);

        // Statistics
        $totalOverdue = Borrow::where('due_date', '<', now())
            ->whereIn('status', ['issued', 'renewed'])
            ->count();

        $criticalOverdue = Borrow::where('due_date', '<', now()->subDays(7))
            ->whereIn('status', ['issued', 'renewed'])
            ->count();

        $studentsWithOverdue = Borrow::where('due_date', '<', now())
            ->whereIn('status', ['issued', 'renewed'])
            ->distinct('user_id')
            ->count('user_id');

        $totalPotentialFines = $totalOverdue * 5; // EMIHLE - dat quick maths twin

        // Return the renamed view
        return view('admin.overdue-books', compact(
            'admin',
            'overdueBooks',
            'totalOverdue',
            'criticalOverdue',
            'studentsWithOverdue',
            'totalPotentialFines'
        ));
    }
}