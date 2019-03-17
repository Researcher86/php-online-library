<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SendEmailEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $address;
    public $body;

    /**
     * Create a new event instance.
     *
     * @param $address
     * @param $body
     */
    public function __construct($address, $body)
    {
        $this->address = $address;
        $this->body = $body;
    }

}
