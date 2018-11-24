<?php

namespace Tests\Unit\Models;

use App\Models\Genre;
use Tests\TestCase;

class GenreTest extends TestCase
{
    public function testCreate()
    {
        $genre = factory(Genre::class)->create();
        $this->assertNotNull($genre);
    }
}
