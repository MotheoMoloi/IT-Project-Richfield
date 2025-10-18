<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showAdminLogin()
    {
        return view('auth.admin-login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // MOTHEO - 
        if ($credentials['email'] === 'student@richfield.ac.za' && $credentials['password'] === 'password') {
            $user = new User([
                'id' => 1,
                'name' => 'Demo Student',
                'student_number' => 'STU2024001',
                'email' => 'student@richfield.ac.za',
                'mobile' => '+27 83 123 4567',
                'address' => '123 Main Street, Johannesburg'
            ]);
        
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->route('user.dashboard');
        }
        // everything here

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('user.dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // MOTHEO - i made a hard coded admin to test out some stuff
        if ($credentials['email'] === 'admin@richfield.ac.za' && $credentials['password'] === 'password') {
            $admin = new Admin([
                'id' => 1,
                'name' => 'Demo Admin',
                'email' => 'admin@richfield.ac.za',
                'position' => 'Head Librarian',
                'department' => 'Library Services',
                'office' => 'Library Building, Office 201',
                'mobile' => '+27 83 987 6543',
                'address' => '456 Admin Avenue, Johannesburg'
            ]);

        // u can delete everything above this
            
            Auth::guard('admin')->login($admin);
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'student_number' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        User::create([
            'name' => $request->name,
            'student_number' => $request->student_number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Registration successful! You can login big dawg.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }

    public function showChangePassword()
    {
        return view('auth.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect dawg.']);
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', 'Password changed successfully.');
    }
}