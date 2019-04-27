<?php

namespace Tests\Integration\Service\Book\Index;

use App\Models\Book\Author;
use App\Models\Book\Book;
use App\Models\Book\Genre;
use App\Services\Book\Index\IndexBookServiceInterface;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class IndexBookServiceTest extends TestCase
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

    public function testSearchFirstResult()
    {
        $books = $this->service->search('В поисках убийцы', 1, 8)->getBooks();
        $firstBook = $books[0];

        self::assertEquals(41, $firstBook->id);
        self::assertEquals('В <b>поисках</b> <b>убийцы</b>', $firstBook->highlight['title'][0]);
    }

    public function testSearchLastResult()
    {
        $books = $this->service->search('В поисках убийцы', 7, 8)->getBooks();
        self::assertEquals(5, count($books));
    }

}
