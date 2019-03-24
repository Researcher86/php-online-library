<?php

namespace Tests\Integration\Service\Index\Elastic;

use App\Models\Book\Author;
use App\Models\Book\Book;
use App\Models\Book\Genre;
use App\Services\Book\Index\IndexBookServiceInterface;
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
        $countBefore = $this->service->count();

        /** @var Book $book */
        $book = factory(Book::class)->create();
        $book->addGenre(factory(Genre::class)->create());
        $book->addAuthor(factory(Author::class)->create());
        $book->save();

        $addResult = $this->service->add($book);
        $updateResult = $this->service->add($book);

        // Даем время для индексации
        sleep(2);

        self::assertTrue($addResult);
        self::assertTrue($updateResult);
        self::assertEquals(1, $this->service->count() - $countBefore);

        // Убираем за собой
        $this->service->delete($book->id);
    }

    public function testSearchByTitle()
    {
        $response = $this->service->searchByTitle('В поисках убийцы')[0];

        self::assertEquals(41, $response->getId());
        self::assertEquals('В поисках убийцы', $response->getTitle());
        self::assertEquals('В <strong>поисках</strong> <strong>убийцы</strong>', $response->getHighlight()['title'][0]);
    }

}
