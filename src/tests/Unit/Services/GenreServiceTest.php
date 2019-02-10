<?php

namespace Tests\Unit\Services;

use App\Services\Book\GenreService;
use Tests\TestCase;

class GenreServiceTest extends TestCase
{

    public function testGetAll()
    {
        $this->assertNotEmpty((new GenreService())->getAll());
    }
}
