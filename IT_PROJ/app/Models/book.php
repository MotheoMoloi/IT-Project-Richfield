<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_name',
        'book_author',
        'category',
        'isbn',
        'year',
        'price',
        'status',
    ];

    /* get the borrows for the book.*/
    public function borrows()
    {
        return $this->hasMany(Borrow::class);
    }

    public function currentBorrower()
    {
        return $this->hasOne(Borrow::class)->where('status', 'issued');
    }

    public function isAvailable()
    {
        return $this->status === 'available';
    }

    public function isCheckedOut()
    {
        return $this->status === 'checked_out';
    }
}