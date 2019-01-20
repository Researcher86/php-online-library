<?php

namespace App\Services\Book;


use App\Models\Book;

class BookService implements BookServiceInterface
{

    public function getAll(int $size = 8)
    {
        return Book::orderBy('created_at', 'asc')->paginate($size);
    }

    public function getById(int $id): Book
    {
        return Book::findOrFail($id)->first();
    }
}