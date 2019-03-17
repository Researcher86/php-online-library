<?php

namespace App\Listeners;

use App\Services\Queue\QueueServiceInterface;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailListener
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $this->queueService->publish(
            config('amqp.queues.notifications.email.name'),
            config('amqp.queues.notifications.email.routing_key'),
            json_encode($event)
        );
    }
}
