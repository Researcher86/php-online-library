<?php

namespace App\Http\Controllers;

use App\Services\Genre\GenreServiceInterface;
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
        return $this->genreService->getAll();
    }
}
