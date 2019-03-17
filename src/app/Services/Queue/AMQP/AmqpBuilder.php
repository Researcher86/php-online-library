<?php

namespace App\Services\Queue\AMQP;


use AMQPChannel;
use AMQPConnection;
use AMQPExchange;
use AMQPQueue;

class AmqpBuilder
{
    private $conn;
    private $channel;
    private $exchange;

    private function __construct()
    {

    }

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

        return $amqp;
    }

    public function exchange(string $name, string $type)
    {
        $this->channel = new AMQPChannel($this->conn);
        $this->exchange = new AMQPExchange($this->channel);
        $this->exchange->setName($name);
        $this->exchange->setType($type);
//        $this->exchange->setFlags(AMQP_DURABLE);
        $this->exchange->declareExchange();

        return $this;
    }

    public function queue(string $name, string $routingKey): AMQPQueue
    {
        $queue = new AMQPQueue($this->channel);
        $queue->setName($name);
        $queue->declareQueue();
        $queue->bind($this->exchange->getName(), $routingKey);

        return $queue;
    }

    /**
     * @return mixed
     */
    public function getExchange()
    {
        return $this->exchange;
    }

}