<?php

namespace App\Http\Controllers;

use App\Services\Book\BookServiceInterface;
use App\Services\Book\GenreServiceInterface;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * @var GenreServiceInterface
     */
    private $genreService;
    /**
     * @var BookServiceInterface
     */
    private $bookService;

    /**
     * HomeController constructor.
     * @param GenreServiceInterface $genreService
     * @param BookServiceInterface $bookService
     */
    public function __construct(GenreServiceInterface $genreService, BookServiceInterface $bookService)
    {
        $this->genreService = $genreService;
        $this->bookService = $bookService;
    }

    public function index()
    {
        $genres = $this->genreService->getAll();
        $books = $this->bookService->getAll(8);

        return view('home', ['genres' => $genres, 'books' => $books]);
    }
}
