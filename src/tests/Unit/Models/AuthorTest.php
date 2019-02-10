<?php

namespace Tests\Unit\Models;

use App\Models\Book\Author;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    public function testCreate()
    {
        $author = factory(Author::class)->create();
        $this->assertNotNull($author);
    }
}
