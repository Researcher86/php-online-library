<?php

namespace App\Services\Queue\AMQP;


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

    public function publish(string $queue, string $routingKey, string $data): void
    {
        try {
            $this->amqpBuilder->publish($queue, $routingKey, $data);
        } catch (\AMQPException $e) {
            throw new \RuntimeException("An error occurred while sending the message", 1, $e);
        }
    }

    public function consume(string $queue, string $routingKey, bool $isWait, callable $handler): void
    {
        try {
            $this->amqpBuilder->consume($queue, $routingKey, $isWait, $handler);
        } catch (\AMQPException $e) {
            throw new \RuntimeException("Error initializing consumer", 1, $e);
        }
    }
}