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
}
