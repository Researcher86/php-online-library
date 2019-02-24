<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BooksControllerTest extends TestCase
{

    public function testGetAll()
    {
        $response = $this->json('GET', '/api/books');

        $response->assertStatus(200)
                  ->assertJsonCount(8, 'data');
    }

    public function testGetById()
    {
        $response = $this->json('GET', '/api/books/1');

        $response->assertStatus(200)
                 ->assertJsonCount(1, 'data');
    }

    public function testGetByGenre()
    {
        $response = $this->json('GET', '/api/books/genres/1');

        $response->assertStatus(200)
            ->assertJsonCount(8, 'data');
    }

    public function testAddRating()
    {
        $response = $this->json('GET', '/api/books/1/rating/5');

        $response->assertStatus(200);
    }
}
