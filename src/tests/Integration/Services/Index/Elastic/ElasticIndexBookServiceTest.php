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

    /**
     * @var Book
     */
    private $book;

    protected function setUp()
    {
        parent::setUp();

        $this->service = App::make(IndexBookServiceInterface::class);

        $this->book = Book::findOrFail(1);
    }


    public function testAdd()
    {
        $countBefore = $this->service->count();

        $this->service->add($this->book);

        //
        sleep(2);

        self::assertEquals(1, $this->service->count() - $countBefore);

        // Restore data
        $this->service->delete($this->book);
        $this->service->add($this->book);
    }

}
