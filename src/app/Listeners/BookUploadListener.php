<?php

namespace App\Listeners;

use App\Events\BookUploadEvent;
use App\Services\Queue\QueueServiceInterface;

class BookUploadListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  BookUploadEvent $event
     * @return void
     */
    public function handle(BookUploadEvent $event)
    {
//        Amqp::publish(/*'book.upload'*/'', json_encode($event), ['queue' => 'book-upload']);
    }
}
