<?php

namespace App\Services\Queue;


interface QueueServiceInterface
{
    /**
     * @param string $queue
     * @param string $routingKey
     * @param string $data
     */
    public function publish(string $queue, string $routingKey, string $data): void;

    /**
     * @param string $queue
     * @param string $routingKey
     * @param bool $isWait
     * @param callable $handler
     */
    public function consume(string $queue, string $routingKey, bool $isWait, callable $handler): void;
}