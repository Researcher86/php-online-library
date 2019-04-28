<?php

namespace App\Http\Controllers;

use App\Services\Book\BookServiceInterface;
use App\Services\Book\GenreServiceInterface;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * @var BookServiceInterface
     */
    private $bookService;

    /**
     * HomeController constructor.
     * @param BookServiceInterface $bookService
     */
    public function __construct(BookServiceInterface $bookService)
    {
        $this->bookService = $bookService;
    }

    public function index()
    {
        $books = $this->bookService->getAll(8);

        return view('home', ['books' => $books]);
    }
}
