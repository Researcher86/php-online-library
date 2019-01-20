<?php

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BooksTableSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 20; $i++) {
            factory(Book::class)->create();
        }
    }
}