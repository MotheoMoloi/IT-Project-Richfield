<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'isbn' => 'required|string|unique:books',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
        ]);

        Book::create($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Book added successfully.');
    }
}