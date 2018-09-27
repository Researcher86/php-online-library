<?php

namespace Tests\Unit;

use App\Models\Author;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    public function testCreate()
    {
        $author = factory(Author::class)->create();
        $this->assertNotNull($author);
    }
}
