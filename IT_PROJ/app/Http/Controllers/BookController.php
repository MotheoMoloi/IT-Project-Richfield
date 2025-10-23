<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function create()
    {
        return view('admin.add-book');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_name' => 'required|string|max:255',
            'book_author' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'isbn' => 'required|string|unique:books',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'price' => 'nullable|numeric|min:0',
            'status' => 'required|in:available,checked_out,reserved',
        ]);

        Book::create($validated);

        return redirect()->route('admin.books.manage')->with('success', 'Book added successfully.');
    }

    public function index()
    {
        $books = Book::where('status', 'available')
            ->orderBy('book_name')
            ->paginate(12);

        return view('user.book-browse', compact('books'));
    }

    public function show($id)
    {
        $book = Book::findOrFail($id);
        return view('user.book-details', compact('book'));
    }
}