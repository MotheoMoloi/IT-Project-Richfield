<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookController;

// Authentication Routes
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Authentication
Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'adminLogin']);

// User Routes (Protected)
Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/user/profile', [UserController::class, 'showProfile'])->name('user.profile');
    Route::get('/user/profile/edit', [UserController::class, 'editProfile'])->name('user.profile.edit');
    Route::put('/user/profile', [UserController::class, 'updateProfile'])->name('user.profile.update');
    Route::get('/user/issued-books', [UserController::class, 'issuedBooks'])->name('user.issued-books');
});

// Admin Routes (Protected)
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/profile', [AdminController::class, 'showProfile'])->name('admin.profile');
    Route::get('/admin/profile/edit', [AdminController::class, 'editProfile'])->name('admin.profile.edit');
    Route::put('/admin/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
    Route::get('/admin/books/create', [BookController::class, 'create'])->name('admin.books.create');
    Route::post('/admin/books', [BookController::class, 'store'])->name('admin.books.store');
});

// Change Password (accessible to both)
Route::middleware(['auth'])->group(function () {
    Route::get('/change-password', [AuthController::class, 'showChangePassword'])->name('password.change');
    Route::post('/change-password', [AuthController::class, 'changePassword']);
});