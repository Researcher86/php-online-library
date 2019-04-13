<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BooksControllerTest extends TestCase
{

    public function testBookShow()
    {
        $response = $this->get('/books/1');

        $response->assertStatus(200)
                 ->assertViewIs('book.show')
                 ->assertViewHasAll(['book']);
    }

    public function testGetByGenre()
    {
        $response = $this->get('/books/genres/1');

        $response->assertStatus(200)
            ->assertViewIs('home')
            ->assertViewHasAll(['genres', 'books']);
    }

    public function testAddRating()
    {
        $response = $this->json('POST', '/api/books/1/rating/5');

        $response->assertStatus(200);
    }
}
