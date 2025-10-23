<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;

// Authentication Routes
Route::get('/', [AuthController::class, 'showLogin'])->name('home');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Authentication
Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login.form');
Route::post('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login.post');

// Change Password (accessible to both)
Route::middleware(['auth'])->group(function () {
    Route::get('/change-password', [AuthController::class, 'showChangePassword'])->name('password.change');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('password.change.post');
});

// User Routes (Protected)
Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/user/profile', [UserController::class, 'showProfile'])->name('user.profile');
    Route::get('/user/profile/edit', [UserController::class, 'editProfile'])->name('user.profile.edit');
    Route::put('/user/profile', [UserController::class, 'updateProfile'])->name('user.profile.update');
    Route::get('/user/issued-books', [UserController::class, 'issuedBooks'])->name('user.issued-books');
    Route::get('/user/borrowing-history', [UserController::class, 'borrowingHistory'])->name('user.borrowing.history');
    Route::get('/user/books/search', [UserController::class, 'searchBooks'])->name('user.books.search');
    Route::get('/user/books/browse', [UserController::class, 'browseBooks'])->name('user.books.browse');
    
    // Borrowing routes
    Route::post('/user/books/{book}/borrow', [BorrowController::class, 'borrowBook'])->name('user.books.borrow');
    Route::post('/user/books/{borrow}/renew', [BorrowController::class, 'renewBook'])->name('user.books.renew');
    Route::post('/user/books/{borrow}/return', [BorrowController::class, 'returnBook'])->name('user.books.return');
});

// Admin Routes (Protected)
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/profile', [AdminController::class, 'showProfile'])->name('admin.profile');
    Route::get('/admin/profile/edit', [AdminController::class, 'editProfile'])->name('admin.profile.edit');
    Route::put('/admin/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
    
    // Book Management
    Route::get('/admin/books/create', [BookController::class, 'create'])->name('admin.books.create');
    Route::post('/admin/books', [BookController::class, 'store'])->name('admin.books.store');
    Route::get('/admin/books', [AdminController::class, 'manageBooks'])->name('admin.books.manage');
    Route::get('/admin/books/{id}/edit', [AdminController::class, 'editBook'])->name('admin.books.edit');
    Route::put('/admin/books/{id}', [AdminController::class, 'updateBook'])->name('admin.books.update');
    Route::delete('/admin/books/{id}', [AdminController::class, 'deleteBook'])->name('admin.books.delete');
    
    // User Management
    Route::get('/admin/users', [AdminController::class, 'manageUsers'])->name('admin.users.index');
    Route::get('/admin/users/{id}', [AdminController::class, 'showUser'])->name('admin.users.show');
    Route::put('/admin/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    
    // Borrow Management
    Route::get('/admin/borrows', [AdminController::class, 'manageBorrows'])->name('admin.borrows.index');
    Route::get('/admin/borrows/overdue', [AdminController::class, 'overdueBooks'])->name('admin.borrows.overdue');
    Route::post('/admin/borrows/{id}/return', [BorrowController::class, 'adminReturnBook'])->name('admin.borrows.return');
});