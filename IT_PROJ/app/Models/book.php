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


    public function borrowingHistory()
    {
        return $this->hasMany(Borrow::class)->orderBy('created_at', 'desc');
    }


    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    //will only give the checked_out books
    public function scopeCheckedOut($query)
    {
        return $query->where('status', 'checked_out');
    }
}