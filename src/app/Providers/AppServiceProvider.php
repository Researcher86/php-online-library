<?php

namespace App\Providers;

use App\Services\Book\BookService;
use App\Services\Book\BookServiceInterface;
use App\Services\Book\GenreService;
use App\Services\Book\GenreServiceInterface;
use Illuminate\Support\Facades\DB;
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
        if (env('PHPUNIT')) {
            DB::listen(function ($query) {
                print_r([
                    $query->sql,
                    $query->bindings,
                    $query->time
                ]);
            });
        }
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
