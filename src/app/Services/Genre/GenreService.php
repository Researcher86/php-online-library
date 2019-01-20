<?php

namespace App\Services\Genre;


use App\Models\Genre;

class GenreService implements GenreServiceInterface
{

    public function getAll(): array
    {
        return Genre::all()->all();
    }
}