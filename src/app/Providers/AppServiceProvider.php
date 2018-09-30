<?php

namespace App\Providers;

use App\Services\Genres\GenreService;
use App\Services\Genres\GenreServiceInterface;
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
    }
}
