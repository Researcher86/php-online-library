<?php

namespace Tests\Unit\Services;

use App\Services\Genre\GenreService;
use Tests\TestCase;

class GenreServiceTest extends TestCase
{

    public function testGetAll()
    {
        $this->assertNotEmpty((new GenreService())->getAll());
    }
}
