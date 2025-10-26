<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Borrow extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'issue_date',
        'due_date',
        'return_date',
        'status',
        'renewal_count',
        'fine_amount',
        'notes',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'due_date' => 'date',
        'return_date' => 'date',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function book()
    {
        return $this->belongsTo(Book::class);
    }


    public function canRenew()
    {
        $maxRenewals = 2; 
        $daysBeforeRenewal = 2; 
        
        return $this->status === 'issued' && 
               $this->renewal_count < $maxRenewals &&
               $this->due_date->diffInDays(Carbon::now()) <= $daysBeforeRenewal;
    }


    public function isOverdue()
    {
        return $this->status === 'issued' && $this->due_date->isPast();
    }

    public function calculateFine()
    {
        if (!$this->isOverdue()) {
            return 0;
        }

        $finePerDay = 5.00; 
        $daysOverdue = $this->due_date->diffInDays(Carbon::now());
        
        return $daysOverdue * $finePerDay;
    }

    /* Scope a query to only include issued books. */
    public function scopeIssued($query)
    {
        return $query->where('status', 'issued');
    }

    /* Scope a query to only include overdue books.*/
    public function scopeOverdue($query)
    {
        return $query->where('status', 'issued')
                    ->where('due_date', '<', Carbon::now());
    }

     /* Scope a query to only include returned books.*/
    public function scopeReturned($query)
    {
        return $query->where('status', 'returned');
    }

    /* Get the number of days overdue.*/
    public function getDaysOverdueAttribute()
    {
        if (!$this->isOverdue()) {
            return 0;
        }
        
        return $this->due_date->diffInDays(Carbon::now());
    }

    /* Get the number of days until due.*/
    public function getDaysUntilDueAttribute()
    {
        if ($this->due_date->isPast()) {
            return 0;
        }
        
        return $this->due_date->diffInDays(Carbon::now());
    }
}