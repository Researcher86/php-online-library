<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Services\Book\BookServiceInterface;
use App\Services\Book\GenreServiceInterface;
use App\Services\Book\Index\IndexBookServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
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
     * @var IndexBookServiceInterface
     */
    private $indexBookService;

    /**
     * Create a new controller instance.
     *
     * @param BookServiceInterface $bookService
     * @param GenreServiceInterface $genreService
     * @param IndexBookServiceInterface $indexBookService
     */
    public function __construct(BookServiceInterface $bookService, GenreServiceInterface $genreService, IndexBookServiceInterface $indexBookService)
    {
        $this->bookService = $bookService;
        $this->genreService = $genreService;
        $this->indexBookService = $indexBookService;
    }

    /**
     * Show book.
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
        try {
            $result = $this->bookService->addRating(Auth::id(), $bookId, $rating);
            return response(['msg' => 'Your rating is saved.', 'rating' => $result], 200);
        } catch (\DomainException $e) {
            return response($e->getMessage(), 400);
        }

    }

    public function search(Request $request)
    {
        if (empty(trim($request->get('q')))) {
            abort(404);
        }

        $limit = 8;
        $page = $request->get('page', 1);

        $genres = $this->genreService->getAll();
        $result = $this->indexBookService->search($request->get('q'), $page, $limit);

        $books = new LengthAwarePaginator($result->getBooks(), $result->getTotal(), $limit, $page, ['path' => Paginator::resolveCurrentPath(), 'pageName' => 'page']);

        return view('search', ['genres' => $genres, 'books' => $books, 'total' => $result->getTotal()]);
    }
}
