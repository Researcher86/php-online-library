<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Services\Book\BookServiceInterface;
use App\Services\Book\GenreServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BooksController extends Controller
{
    private $bookService;
    /**
     * @var GenreServiceInterface
     */
    private $genreService;

    /**
     * Create a new controller instance.
     *
     * @param BookServiceInterface $bookService
     * @param GenreServiceInterface $genreService
     */
    public function __construct(BookServiceInterface $bookService, GenreServiceInterface $genreService)
    {
        $this->bookService = $bookService;
        $this->genreService = $genreService;
    }

    /**
     * Show the application dashboard.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(int $id)
    {
        $book = $this->bookService->getById($id);
        return view('book.show', ['book' => $book]);
    }

    /**
     * Get book by genre.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getBooksByGenre(int $id)
    {
        $genres = $this->genreService->getAll();
        $books = $this->bookService->getBooksByGenre($id, 8);

        return view('home', ['genres' => $genres, 'books' => $books]);
    }

    /**
     * Add rating for book.
     *
     * @param int $bookId
     * @param int $rating
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
