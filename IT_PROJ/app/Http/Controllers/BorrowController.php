<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BorrowController extends Controller
{
    public function borrowBook(Request $request, $bookId)
    {
        $user = Auth::user();
        $book = Book::findOrFail($bookId);

        // Check if book is available
        if ($book->status !== 'available') {
            return redirect()->back()->with('error', 'This book is not available for borrowing.');
        }

        // Check if user has reached borrowing limit (e.g., 5 books)
        $currentBorrows = Borrow::where('user_id', $user->id)
            ->where('status', 'issued')
            ->count();

        if ($currentBorrows >= 5) {
            return redirect()->back()->with('error', 'You have reached the maximum borrowing limit of 5 books.');
        }

        // Check if user already has this book
        $existingBorrow = Borrow::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->where('status', 'issued')
            ->exists();

        if ($existingBorrow) {
            return redirect()->back()->with('error', 'You have already borrowed this book.');
        }

        // Create borrow record
        $borrow = Borrow::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'issue_date' => Carbon::now(),
            'due_date' => Carbon::now()->addDays(14), // 2 weeks loan period
            'status' => 'issued',
        ]);

        // Update book status
        $book->update(['status' => 'checked_out']);

        return redirect()->route('user.issued-books')->with('success', 'Book borrowed successfully. Due date: ' . $borrow->due_date->format('M d, Y'));
    }

    public function renewBook($borrowId)
    {
        $user = Auth::user();
        $borrow = Borrow::where('id', $borrowId)
            ->where('user_id', $user->id)
            ->firstOrFail();

        // Check if borrow can be renewed
        if (!$borrow->canRenew()) {
            return redirect()->back()->with('error', 'This book cannot be renewed. You may have reached the renewal limit or it\'s too early to renew.');
        }

        // Renew the book (extend due date by 1 week)
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

        // Calculate fine if overdue
        $fineAmount = 0;
        if ($borrow->due_date->isPast()) {
            $fineAmount = $borrow->calculateFine();
        }

        // Update borrow record
        $borrow->update([
            'return_date' => Carbon::now(),
            'status' => 'returned',
            'fine_amount' => $fineAmount,
        ]);

        // Update book status
        $book = Book::find($borrow->book_id);
        $book->update(['status' => 'available']);

        $message = 'Book returned successfully.';
        if ($fineAmount > 0) {
            $message .= ' Fine amount: R' . number_format($fineAmount, 2);
        }

        return redirect()->back()->with('success', $message);
    }

    public function borrowingHistory()
    {
        $user = Auth::user();
        $borrowingHistory = Borrow::with('book')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.borrowing-history', compact('borrowingHistory'));
    }

    // Admin methods for managing borrows
    public function adminReturnBook($borrowId)
    {
        $borrow = Borrow::findOrFail($borrowId);

        // Calculate fine if overdue
        $fineAmount = 0;
        if ($borrow->due_date->isPast()) {
            $fineAmount = $borrow->calculateFine();
        }

        // Update borrow record
        $borrow->update([
            'return_date' => Carbon::now(),
            'status' => 'returned',
            'fine_amount' => $fineAmount,
        ]);

        // Update book status
        $book = Book::find($borrow->book_id);
        $book->update(['status' => 'available']);

        $message = 'Book returned successfully.';
        if ($fineAmount > 0) {
            $message .= ' Fine amount: R' . number_format($fineAmount, 2);
        }

        return redirect()->back()->with('success', $message);
    }
}