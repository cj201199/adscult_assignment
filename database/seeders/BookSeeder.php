<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::create(['title' => 'Book 1', 'author' => 'Author 1']);
        Book::create(['title' => 'Book 2', 'author' => 'Author 2']);
    }
}
