<?php

namespace App\Services\Book;


use App\Models\Book\Book;

interface BookServiceInterface
{
    public function getAll(int $size);

    public function getById(int $id): Book;

    public function getBooksByGenre(int $genreId, int $size);

    public function addRating(int $userId, int $bookId, int $rating): float;

    public function getTop(int $limit);
}