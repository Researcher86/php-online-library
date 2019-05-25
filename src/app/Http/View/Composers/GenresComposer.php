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
     * @param View $view
     * @return void
     * @throws \Exception
     */
    public function compose(View $view)
    {
        $genres = \cache()->remember('genres', now()->addMinutes(1), function () {
            return $this->genreService->getAll();
        });
        $view->with('genres', $genres);
    }
}