<?php

namespace Tests\Integration\Service\Index\Elastic;

use App\Services\Index\IndexBookServiceInterface;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class ElasticIndexBookServiceTest extends TestCase
{
    /**
     * @var IndexBookServiceInterface
     */
    private $service;

    protected function setUp()
    {
        parent::setUp();

        $this->service = App::make(IndexBookServiceInterface::class);
    }


    public function testAdd()
    {

        self::assertTrue(true);
    }

}
