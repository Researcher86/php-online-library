<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SendSmsEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $phoneNumber;
    public $message;

    /**
     * Create a new event instance.
     *
     * @param $phoneNumber
     * @param $message
     */
    public function __construct($phoneNumber, $message)
    {
        $this->phoneNumber = $phoneNumber;
        $this->message = $message;
    }

}
