<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'student_number',
        'email',
        'password',
        'mobile',
        'address',
        'program',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /* gets the borrows for the user. */
    public function borrows()
    {
        return $this->hasMany(Borrow::class);
    }

    /* gets the currently borrowed books.*/
    public function borrowedBooks()
    {
        return $this->hasMany(Borrow::class)->where('status', 'issued');
    }

    /* gets the borrowing history.*/
    public function borrowingHistory()
    {
        return $this->hasMany(Borrow::class)->orderBy('created_at', 'desc');
    }

    public function returnedBooks()
    {
        return $this->hasMany(Borrow::class)->where('status', 'returned');
    }

    public function overdueBooks()
    {
        return $this->hasMany(Borrow::class)->overdue();
    }


    public function hasReachedBorrowingLimit()
    {
        $maxBooks = 100;
        return $this->borrowedBooks()->count() >= $maxBooks;
    }


    public function getTotalFinesAttribute()
    {
        return $this->borrows()->sum('fine_amount');
    }
}