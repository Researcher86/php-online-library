<?php

namespace App\Services\Queue\AMQP;


use AMQPEnvelope;
use AMQPQueue;
use App\Services\Queue\QueueServiceInterface;

class AmqpService implements QueueServiceInterface
{
    private $amqpBuilder;

    /**
     * AmqpService constructor.
     * @param AmqpBuilder $amqpBuilder
     */
    public function __construct(AmqpBuilder $amqpBuilder)
    {
        $this->amqpBuilder = $amqpBuilder;
    }

    public function publish(string $queue, string $routingKey, string $data)
    {
        $this->amqpBuilder->queue($queue, $routingKey);
        $this->amqpBuilder->getExchange()->publish(json_encode($data), $routingKey, AMQP_NOPARAM, ['delivery_mode' => 2]);
    }

    public function consume(string $queue, string $routingKey, callable $handler)
    {
        $this->amqpBuilder->queue($queue, $routingKey)->consume(function (AMQPEnvelope $envelope, AMQPQueue $queue) use ($handler) {
            $result = $handler(json_decode($envelope->getBody()));
            $queue->ack($envelope->getDeliveryTag());
            return $result;
        });
    }
}