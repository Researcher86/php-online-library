<?php

namespace App\Providers;

use AMQPChannel;
use AMQPConnection;
use AMQPExchange;
use AMQPQueue;
use App\Services\Book\BookService;
use App\Services\Book\BookServiceInterface;
use App\Services\Genre\GenreService;
use App\Services\Genre\GenreServiceInterface;
use App\Services\Queue\QueueServiceInterface;
use App\Services\Queue\RabbitQueueService;
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
