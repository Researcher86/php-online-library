<?php

namespace App\Providers;

use App\Services\Book\BookService;
use App\Services\Book\BookServiceInterface;
use App\Services\Genre\GenreService;
use App\Services\Genre\GenreServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(GenreServiceInterface::class, function ($app) {
            return new GenreService();
        });
        $this->app->singleton(BookServiceInterface::class, function ($app) {
            return new BookService();
        });
    }
}
