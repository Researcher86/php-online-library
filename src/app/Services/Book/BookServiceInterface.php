<?php

namespace App\Services\Book;


use App\Models\Book;

interface BookServiceInterface
{
    public function getAll(int $size = 8);

    public function getById(int $id): Book;
}