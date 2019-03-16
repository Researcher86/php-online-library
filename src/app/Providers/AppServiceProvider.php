<?php

namespace App\Providers;

use App\Services\Book\BookService;
use App\Services\Book\BookServiceInterface;
use App\Services\Book\GenreService;
use App\Services\Book\GenreServiceInterface;
use App\Services\Queue\AMQP\AmqpBuilder;
use App\Services\Queue\AMQP\AmqpService;
use App\Services\Queue\QueueServiceInterface;
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

        $this->app->singleton(QueueServiceInterface::class, function ($app) {
            /** @var \Illuminate\Foundation\Application $app */


            return new AmqpService(
                AmqpBuilder::connect(
                    config('amqp.connection.host'),
                    config('amqp.connection.vhost'),
                    config('amqp.connection.port'),
                    config('amqp.connection.login'),
                    config('amqp.connection.password')
                )->exchange(
                    config('amqp.connection.exchange'),
                    config('amqp.connection.exchange_type')
                )
            );
        });
    }
}
