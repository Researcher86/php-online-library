<?php

namespace Tests\Unit;

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
