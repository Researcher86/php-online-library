<?php

namespace App\Services\Index;


use App\Models\Book\Book;

interface IndexBookServiceInterface
{
    public function add(Book $book);

    public function restore();

    public function searchByTitle(string $title);

    public function searchByAuthor(string $name);

    public function searchByAnnotation(string $annotation);

    public function count();
}