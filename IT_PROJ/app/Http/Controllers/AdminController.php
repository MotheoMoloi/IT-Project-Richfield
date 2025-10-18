<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.dashboard', compact('admin'));
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
}