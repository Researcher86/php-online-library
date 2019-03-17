<?php

namespace App\Console\Commands;

use App\Services\Queue\QueueServiceInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ConsumerSendSms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:consumer-send-sms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command send SMS notifications';
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
        Log::debug("Consumer Send SMS run");

        $this->queueService->consume(
            config('amqp.queues.notifications.sms.name'),
            config('amqp.queues.notifications.sms.routing_key'),
            true,
            function ($data) {
                Log::info('Send SMS: ' . $data);
            }
        );

        Log::debug("Consumer Send SMS stop");
    }
}
