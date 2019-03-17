<?php

namespace App\Listeners;

use App\Events\BookUploadEvent;
use App\Services\Queue\QueueServiceInterface;

class BookUploadListener
{
    /**
     * @var QueueServiceInterface
     */
    private $queueService;

    /**
     * Create the event listener.
     *
     * @param QueueServiceInterface $queueService
     */
    public function __construct(QueueServiceInterface $queueService)
    {

        $this->queueService = $queueService;
    }

    /**
     * Handle the event.
     *
     * @param  BookUploadEvent $event
     * @return void
     */
    public function handle(BookUploadEvent $event)
    {
        $this->queueService->publish(
            config('amqp.queues.process.book.name'),
            config('amqp.queues.process.book.routing_key'),
            json_encode($event)
        );
    }
}
