<?php


namespace App\Http\View\Composers;


use App\Services\Book\GenreServiceInterface;
use Illuminate\View\View;

class GenresComposer
{
    /**
     * @var GenreServiceInterface
     */
    private $genreService;

    /**
     * GenresComposer constructor.
     * @param GenreServiceInterface $genreService
     */
    public function __construct(GenreServiceInterface $genreService)
    {
        $this->genreService = $genreService;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('genres', $this->genreService->getAll());
    }
}