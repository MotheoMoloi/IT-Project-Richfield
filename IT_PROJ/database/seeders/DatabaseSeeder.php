<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Admin;
use App\Models\Book;
use App\Models\Borrow;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Admin::create([
            'name' => 'Demo Admin',
            'email' => 'admin@richfield.ac.za',
            'password' => Hash::make('password'),
            'position' => 'Head Librarian',
            'department' => 'Library Services',
            'office' => 'Library Building, Office 201',
            'mobile' => '+27 83 987 6543',
            'address' => '456 Admin Avenue, Johannesburg',
        ]);

        User::create([
            'name' => 'Demo Student',
            'student_number' => 'STU2024001',
            'email' => 'student@richfield.ac.za',
            'password' => Hash::make('password'),
            'mobile' => '+27 83 123 4567',
            'address' => '123 Main Street, Johannesburg',
            'program' => 'BSc Computer Science',
        ]);

        $books = [
            [
                'book_name' => 'Introduction to Algorithms',
                'book_author' => 'Thomas H. Cormen',
                'category' => 'Computer Science',
                'isbn' => '9780262033848',
                'year' => 2022,
                'price' => 950.00,
                'status' => 'available',
            ],
            [
                'book_name' => 'Clean Code',
                'book_author' => 'Robert C. Martin',
                'category' => 'Software Engineering',
                'isbn' => '9780132350884',
                'year' => 2020,
                'price' => 620.00,
                'status' => 'available',
            ],
            [
                'book_name' => 'Design Patterns',
                'book_author' => 'Erich Gamma',
                'category' => 'Architecture',
                'isbn' => '9780201633610',
                'year' => 2021,
                'price' => 780.00,
                'status' => 'checked_out',
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }

        // Create sample borrow record
        Borrow::create([
            'user_id' => 1,
            'book_id' => 3, 
            'issue_date' => Carbon::now()->subDays(5),
            'due_date' => Carbon::now()->addDays(2),
            'status' => 'issued',
            'renewal_count' => 0,
            'fine_amount' => 0.00,
        ]);
    }
}