<?php


namespace App\Http\View\Composers;


use App\Services\Book\BookServiceInterface;
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
     * @param View $view
     * @return void
     * @throws \Exception
     */
    public function compose(View $view)
    {
        $topBooks = \cache()->remember('top-books', now()->addMinutes(1), function () {
            return $this->bookService->getTop(5);
        });
        $view->with('topBooks', $topBooks);
    }
}