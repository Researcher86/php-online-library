<?php

namespace App\Console\Commands;

use App\Services\Queue\QueueServiceInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ConsumerBookUpload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:consumer-book-upload';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consumer for upload book';
    /**
     * @var QueueServiceInterface
     */
    private $queueService;

    /**
     * Create a new command instance.
     *
     * @param QueueServiceInterface $queueService
     */
    public function __construct(QueueServiceInterface $queueService)
    {
        parent::__construct();
        $this->queueService = $queueService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Log::debug("Consumer run");

        $this->queueService->consume(
            config('amqp.queues.process.book.name'),
            config('amqp.queues.process.book.routing_key'),
            true,
            function ($data) {
                Log::info($data);
            }
        );

        Log::debug("Consumer stop");
    }
}
