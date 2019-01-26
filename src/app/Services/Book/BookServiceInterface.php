<?php

namespace App\Services\Book;


use App\Models\Book;

interface BookServiceInterface
{
    public function getAll(int $size);

    public function getById(int $id): Book;

    public function getBooksByGenre(int $genreId, int $size);
}