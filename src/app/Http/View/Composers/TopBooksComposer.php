<?php


namespace App\Http\View\Composers;


use App\Services\Book\BookServiceInterface;
use App\Services\Book\GenreServiceInterface;
use Illuminate\View\View;

class TopBooksComposer
{
    /**
     * @var BookServiceInterface
     */
    private $bookService;

    /**
     * GenresComposer constructor.
     * @param BookServiceInterface $bookService
     */
    public function __construct(BookServiceInterface $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('topBooks', $this->bookService->getTop(5));
    }
}