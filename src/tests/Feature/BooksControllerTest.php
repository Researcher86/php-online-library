<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BooksControllerTest extends TestCase
{

    public function testGetAll()
    {
        $response = $this->json('GET', '/api/books');

        $response->assertStatus(200);
    }

    public function testGetById()
    {
        $response = $this->json('GET', '/api/books/1');

        $response->assertStatus(200);
    }
}
