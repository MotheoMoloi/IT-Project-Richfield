<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\book;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
        [
            'title' => 'English handbook and study guide: A comprehensive engilsh reference book',
            'author' => 'Lutrin B',
            'isbn' => '9780620325837',
            'year' => '2019',
        ],
        [
            'title' => 'About financial accounting(volume2)',
            'author' => 'Ceki B',
            'isbn' => '9780639008660',
            'year' => '2019',
        ],
    ];
    Book::insert($books);
}
}
