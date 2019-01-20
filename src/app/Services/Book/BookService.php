<?php

namespace App\Services\Book;


use App\Models\Book;

class BookService implements BookServiceInterface
{

    public function getAll(): array
    {
        return Book::all()->all();
    }
}