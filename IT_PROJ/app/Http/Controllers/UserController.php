<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $booksBorrowed = 0; //imma add actual books count from database
        
        return view('user.dashboard', compact('user', 'booksBorrowed'));
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
        ]);

        $user->update($validated);

        return redirect()->route('user.profile')->with('success', 'Profile updated successfully.');
    }

    public function issuedBooks()
    {
        $user = Auth::user();
        $issuedBooks = []; // imma add actual data here
        
        return view('user.issued-books', compact('user', 'issuedBooks'));
    }
}