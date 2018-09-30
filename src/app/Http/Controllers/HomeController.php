<?php

namespace App\Http\Controllers;

use App\Services\Genres\GenreServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
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
    public function index()
    {
        $genres = $this->genreService->getAll();
        return view('home', compact('genres'));
    }
}
