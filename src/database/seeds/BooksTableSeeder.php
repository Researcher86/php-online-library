<?php

use App\Models\Book;
use App\Models\Genre;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BooksTableSeeder extends Seeder
{
    public function run()
    {
        $book = factory(Book::class)->create();
        $book->addGenre(Genre::findOrFail(1));

        for ($i = 0; $i < 20; $i++) {
            $book = factory(Book::class)->create();
            $book->addGenre(Genre::findOrFail(random_int(3, 23)));
        }
    }
}