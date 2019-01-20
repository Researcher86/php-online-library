<?php

namespace App\Http\Controllers;

use App\Services\Book\BookServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BooksController extends Controller
{
    private $bookService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BookServiceInterface $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        return $this->bookService->getAll();
    }
}
