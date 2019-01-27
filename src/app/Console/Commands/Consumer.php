<?php

namespace App\Console\Commands;

use Bschmitt\Amqp\Facades\Amqp;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class Consumer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:consumer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consumer for queue books';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        Log::debug("Consumer created");
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Log::debug("Consumer handler");
        Amqp::consume('book-upload', function ($message, $resolver) {
            Log::debug($message->body);

            $resolver->acknowledge($message);
        });
    }
}
