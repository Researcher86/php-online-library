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

        $this->app->singleton(QueueServiceInterface::class, function ($app) {
            $conn = new AMQPConnection([
                'host' => env('RABBIT_HOST'),
                'vhost' => env('RABBIT_VHOST'),
                'port' => env('RABBIT_PORT'),
                'login' => env('RABBIT_LOGIN'),
                'password' => env('RABBIT_PASSWORD')
            ]);
            $conn->connect();

            $channel = new AMQPChannel($conn);
            $exchange = new AMQPExchange($channel);
            $exchange->setName('message-exchange');
            $exchange->setType(AMQP_EX_TYPE_DIRECT);
            //$exchange->setFlags(AMQP_DURABLE);
            $exchange->declareExchange();

            $queue = new AMQPQueue($channel);
            $queue->setName("log-info");
            $queue->declareQueue();
            $queue->bind($exchange->getName(), 'log.info');

            return new RabbitQueueService($exchange, $queue);
        });
    }
}
