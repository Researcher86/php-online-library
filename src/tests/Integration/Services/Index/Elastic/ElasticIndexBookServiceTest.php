<?php

namespace Tests\Integration\Service\Index\Elastic;

use App\Models\Book\Author;
use App\Models\Book\Book;
use App\Models\Book\Genre;
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
        /** @var Book $book */
        $book = factory(Book::class)->create();
        $book->addGenre(factory(Genre::class)->create());
        $book->addAuthor(factory(Author::class)->create());
        $book->save();

        $addResult = $this->service->add($book);
        $updateResult = $this->service->add($book);

        self::assertEquals($book->id, $addResult['_id']);
        self::assertEquals('created', $addResult['result']);
        self::assertEquals($book->id, $updateResult['_id']);
        self::assertEquals('updated', $updateResult['result']);

        // Restore data
        $this->service->delete($book);
    }

    public function testSearchByTitle()
    {
        $response = $this->service->searchByTitle('В поисках убийцы');
        $book = $response[0];

        self::assertEquals(41, $book['id']);
        self::assertEquals('В поисках убийцы', $book['title']);
    }

}
