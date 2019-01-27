<?php
/**
 * Created by PhpStorm.
 * User: Tanat
 * Date: 27.01.2019
 * Time: 12:24
 */

namespace App\Services\Queue;


use AMQPEnvelope;
use AMQPExchange;
use AMQPQueue;

class RabbitQueueService implements QueueServiceInterface
{
    /**
     * @var AMQPExchange
     */
    private $exchange;
    /**
     * @var AMQPQueue
     */
    private $queue;

    /**
     * RabbitQueueService constructor.
     */
    public function __construct(AMQPExchange $exchange, AMQPQueue $queue)
    {
        $this->exchange = $exchange;
        $this->queue = $queue;
    }

    public function produce($data, array $params)
    {
        $this->exchange->publish(json_encode($data), $params['routing_key'], AMQP_NOPARAM, ['delivery_mode' => 2]);
    }

    public function consume(callable $fun)
    {
        $this->queue->consume(function (AMQPEnvelope $envelope, AMQPQueue $queue) use ($fun) {
            $fun(json_decode($envelope->getBody()));
            $queue->ack($envelope->getDeliveryTag());
        });
    }
}