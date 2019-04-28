<?php

namespace Tests\Feature;

use App\Models\Book\Book;
use App\Models\User;
use Tests\TestCase;

class BooksControllerTest extends TestCase
{

    public function testBookShow()
    {
        $response = $this->get('/books/1');

        $response->assertStatus(200)
                 ->assertViewIs('book.show')
                 ->assertViewHasAll(['book', 'topBooks']);
    }

    public function testGetByGenre()
    {
        $response = $this->get('/books/genres/1');

        $response->assertStatus(200)
            ->assertViewIs('home')
            ->assertViewHasAll(['genres', 'books', 'topBooks']);
    }

    public function testAddRating()
    {
        $user = User::findOrFail(3);

        $book = factory(Book::class)->create();

        $this->actingAs($user)->post('/books/' . $book->id . '/rating/5')
                              ->assertStatus(200)
                              ->assertJsonFragment(['msg' => 'Your rating is saved.', 'rating' => 5]);
    }

    public function testAddRatingHasError()
    {
        $user = User::findOrFail(3);
        $this->actingAs($user)->post('/books/1/rating/5');

        $this->actingAs($user)->post('/books/1/rating/5')
                              ->assertStatus(400)
                              ->assertSee('You can not put the rating more than once.');
    }
}
