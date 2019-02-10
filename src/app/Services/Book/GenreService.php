<?php

namespace App\Services\Book;


use App\Models\Book\Genre;

class GenreService implements GenreServiceInterface
{

    public function getAll(): array
    {
        return Genre::all()->all();
    }
}