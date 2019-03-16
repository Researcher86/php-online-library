<?php

namespace App\Services\Queue;


interface QueueServiceInterface
{
    public function publish(string $queue, string $routingKey, string $data);
    public function consume(string $queue, string $routingKey, callable $handler);
}