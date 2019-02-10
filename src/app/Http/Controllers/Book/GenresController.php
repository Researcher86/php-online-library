<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Services\Book\GenreServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class GenresController extends Controller
{
    private $genreService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(GenreServiceInterface $genreService)
    {
        $this->genreService = $genreService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        return response(
            $this->genreService->getAll()
        );
    }
}
