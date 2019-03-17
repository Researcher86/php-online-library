<?php

namespace Tests\Integration\Service\Queue\AMQP;

use App\Services\Queue\AMQP\AmqpBuilder;
use App\Services\Queue\AMQP\AmqpService;
use Tests\TestCase;

class AmqpServiceTest extends TestCase
{
    /**
     * @var AmqpService
     */
    private $service;

    protected function setUp()
    {
        $this->service = new AmqpService(
            AmqpBuilder::connect(
                env('RABBIT_HOST'),
                env('RABBIT_VHOST'),
                env('RABBIT_PORT'),
                env('RABBIT_LOGIN'),
                env('RABBIT_PASSWORD')
            )->exchange(
                'Test',
                AMQP_EX_TYPE_TOPIC
            )
        );
    }


    public function testPubSub()
    {
        $this->service->publish('test', 'test', 'Data');
        $result = '';
        $this->service->consume('test', 'test', false, function ($data) use (&$result) {
            $result = $data;
        });

        self::assertEquals('Data', $result);
    }

}
