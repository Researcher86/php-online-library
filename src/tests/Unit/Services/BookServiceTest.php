<?php

namespace Tests\Unit\Services;

use App\Services\Book\BookService;
use Tests\TestCase;

class BookServiceTest extends TestCase
{

    public function testGetAll()
    {
        $this->assertNotEmpty((new BookService())->getAll());
    }

    public function testGetById()
    {
        $this->assertNotEmpty((new BookService())->getById(1));
    }

    public function testGetBooksByGenre()
    {
        $books = (new BookService())->getBooksByGenre(1);
        self::assertNotNull($books);
        self::assertEquals(8, $books->count());
    }
}
