<?php

namespace App\Services\Queue\AMQP;


use AMQPChannel;
use AMQPConnection;
use AMQPEnvelope;
use AMQPExchange;
use AMQPQueue;

class AmqpBuilder
{
    /**
     * @var AMQPConnection
     */
    private $conn;
    /**
     * @var AMQPChannel
     */
    private $channel;
    /**
     * @var AMQPExchange
     */
    private $exchange;

    private function __construct()
    {

    }

    /**
     * @param string $host
     * @param string $vhost
     * @param int $port
     * @param string $login
     * @param string $password
     * @return AmqpBuilder
     * @throws \AMQPConnectionException
     */
    public static function connect(string $host, string $vhost, int $port, string $login, string $password)
    {
        $amqp = new self();
        $amqp->conn = new AMQPConnection([
            'host' => $host,
            'vhost' => $vhost,
            'port' => $port,
            'login' => $login,
            'password' => $password
        ]);
        $amqp->conn->connect();
        $amqp->channel = new AMQPChannel($amqp->conn);

        return $amqp;
    }

    /**
     * @param string $name
     * @param string $type
     * @return $this
     * @throws \AMQPChannelException
     * @throws \AMQPConnectionException
     * @throws \AMQPExchangeException
     */
    public function exchange(string $name, string $type)
    {
        $this->exchange = new AMQPExchange($this->channel);
        $this->exchange->setName($name);
        $this->exchange->setType($type);
//        $this->exchange->setFlags(AMQP_DURABLE);
        $this->exchange->declareExchange();

        return $this;
    }

    private function queue(string $name, string $routingKey): AMQPQueue
    {
        $queue = new AMQPQueue($this->channel);
        $queue->setName($name);
        $queue->declareQueue();
        $queue->bind($this->exchange->getName(), $routingKey);

        return $queue;
    }

    /**
     * @param string $queue
     * @param string $routingKey
     * @param string $data
     * @throws \AMQPChannelException
     * @throws \AMQPConnectionException
     * @throws \AMQPExchangeException
     */
    public function publish(string $queue, string $routingKey, string $data)
    {
        $this->queue($queue, $routingKey);
        $this->exchange->publish($data, $routingKey, AMQP_NOPARAM, ['delivery_mode' => 2]);
    }

    /**
     * @param string $queue
     * @param string $routingKey
     * @param bool $isWait
     * @param callable $handler
     * @throws \AMQPChannelException
     * @throws \AMQPConnectionException
     * @throws \AMQPEnvelopeException
     */
    public function consume(string $queue, string $routingKey, bool $isWait, callable $handler)
    {
        $this->queue($queue, $routingKey)->consume(function (AMQPEnvelope $envelope, AMQPQueue $queue) use ($isWait, $handler) {
            $handler($envelope->getBody());
            $queue->ack($envelope->getDeliveryTag());
            return $isWait;
        });
    }

}