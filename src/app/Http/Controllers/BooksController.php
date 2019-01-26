<?php

namespace App\Http\Controllers;

use App\Services\Book\BookServiceInterface;

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
    public function index()
    {
        return $this->bookService->getAll();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return $this->bookService->getById($id);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getBooksByGenre(int $id)
    {
        return $this->bookService->getBooksByGenre($id);
    }
}
