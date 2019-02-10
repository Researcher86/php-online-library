<?php

namespace App\Http\Controllers;

use App\Services\Book\BookServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        return response(
            $this->bookService->getAll()
        );
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return response(
            $this->bookService->getById($id)
        );
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getBooksByGenre(int $id)
    {
        return response(
            $this->bookService->getBooksByGenre($id)
        );
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function addRating(int $bookId, int $rating)
    {
//        if (Auth::guest()) {
//            Log::warning("Guest set book rating", ['userId' => Auth::id(), 'bookId' => $bookId, 'rating' => $rating]);
//            return response('Unauthorized.', 401);
//        }

        return response(
            $this->bookService->addRating(2, $bookId, $rating)
        );
    }
}
