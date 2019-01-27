<?php

namespace App\Services\Queue;

use AMQPChannel;
use AMQPConnection;
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
     * @var string
     */
    private $exchangeName;
    /**
     * @var string
     */
    private $routingKey;
    /**
     * @var string
     */
    private $queueName;

    /**
     * RabbitQueueService constructor.
     * @param string $host
     * @param string $vhost
     * @param int $port
     * @param string $login
     * @param string $password
     * @throws \AMQPChannelException
     * @throws \AMQPConnectionException
     * @throws \AMQPExchangeException
     * @throws \AMQPQueueException
     */
    public function __construct(string $host, string $vhost, int $port, string $login, string $password, string $exchangeName, string $routingKey, string $queueName)
    {
        $conn = new AMQPConnection([
            'host' => $host,
            'vhost' => $vhost,
            'port' => $port,
            'login' => $login,
            'password' => $password
        ]);
        $conn->connect();

        $channel = new AMQPChannel($conn);
        $exchange = new AMQPExchange($channel);
        $exchange->setName($exchangeName);
        $exchange->setType(AMQP_EX_TYPE_DIRECT);
        //$exchange->setFlags(AMQP_DURABLE);
        $exchange->declareExchange();

        $queue = new AMQPQueue($channel);
        $queue->setName($queueName);
        $queue->declareQueue();
        $queue->bind($exchange->getName(), $routingKey);

        $this->exchange = $exchange;
        $this->queue = $queue;
        $this->exchangeName = $exchangeName;
        $this->routingKey = $routingKey;
        $this->queueName = $queueName;
    }

    public function produce($data)
    {
        $this->exchange->publish(json_encode($data), $this->routingKey, AMQP_NOPARAM, ['delivery_mode' => 2]);
    }

    public function consume(callable $fun)
    {
        $this->queue->consume(function (AMQPEnvelope $envelope, AMQPQueue $queue) use ($fun) {
            $fun(json_decode($envelope->getBody()));
            $queue->ack($envelope->getDeliveryTag());
        });
    }
}