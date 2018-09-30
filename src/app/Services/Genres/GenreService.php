<?php

namespace App\Services\Genres;


use App\Models\Genre;

class GenreService implements GenreServiceInterface
{

    public function getAll(): array
    {
        return Genre::all()->all();
    }
}