<?php

namespace App\Console\Commands;

use App\Services\Queue\QueueServiceInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ConsumerSendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:consumer-send-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command send email notifications';
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
        Log::debug("Consumer Send Email run");

        $this->queueService->consume(config('amqp.queues.notifications.email.name'), config('amqp.queues.notifications.email.routing_key'), function ($data) {
            Log::info('Send Email: ' . $data);
        });

        Log::debug("Consumer Send Email stop");
    }
}
