<?php

namespace Tests\Integration\Service\Index\Elastic;

use App\Models\Book\Book;
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
        $this->service->restore();
    }


    public function testAdd()
    {
        $book1 = Book::findOrFail(1);
        $book2 = Book::findOrFail(2);
        $book3 = Book::findOrFail(3);

        $this->service->add($book1);
        $this->service->add($book2);
        $this->service->add($book3);

        sleep(1);

        self::assertEquals(3, $this->service->count());
    }

}
