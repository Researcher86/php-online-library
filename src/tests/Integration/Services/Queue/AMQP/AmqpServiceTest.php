<?php

namespace Tests\Integration\Service\Queue\AMQP;

use App\Services\Queue\QueueServiceInterface;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class AmqpServiceTest extends TestCase
{
    /**
     * @var QueueServiceInterface
     */
    private $service;

    protected function setUp()
    {
        parent::setUp();

        $this->service = App::make(QueueServiceInterface::class);;
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
