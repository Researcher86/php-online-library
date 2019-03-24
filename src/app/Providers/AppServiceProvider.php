<?php

namespace App\Providers;

use App\Services\Book\BookService;
use App\Services\Book\BookServiceInterface;
use App\Services\Book\GenreService;
use App\Services\Book\GenreServiceInterface;
use App\Services\Book\Index\Elastic\ElasticIndexBookService;
use App\Services\Book\Index\IndexBookServiceInterface;
use App\Services\Queue\AMQP\AmqpBuilder;
use App\Services\Queue\AMQP\AmqpService;
use App\Services\Queue\QueueServiceInterface;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
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
        $this->app->bind(GenreServiceInterface::class, GenreService::class);
        $this->app->bind(BookServiceInterface::class, BookService::class);

        $this->app->singleton(AmqpBuilder::class, function ($app) {
            /** @var \Illuminate\Foundation\Application $app */
            return AmqpBuilder::connect(
                    config('queue.connections.amqp.host'),
                    config('queue.connections.amqp.vhost'),
                    config('queue.connections.amqp.port'),
                    config('queue.connections.amqp.login'),
                    config('queue.connections.amqp.password')
                )->exchange(
                    config('queue.connections.amqp.exchange'),
                    config('queue.connections.amqp.exchange_type')
                );
        });
        $this->app->bind(QueueServiceInterface::class, AmqpService::class);

        $this->app->singleton(Client::class, function ($app) {
            return ClientBuilder::create()->setHosts([config('database.elasticsearch.host')])->build();
        });
        $this->app->bind(IndexBookServiceInterface::class, ElasticIndexBookService::class);
    }
}
