<?php

namespace Tests\Unit\Models;

use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Rating;
use App\Models\User;
use Tests\TestCase;

class BookTest extends TestCase
{
    public function testCreate()
    {
        /** @var Book $book */
        $book = factory(Book::class)->create();
        $this->assertNotNull($book);

        $book->addAuthors(factory(Author::class)->create());
        $book->addGenres(factory(Genre::class)->create());

        $book->addRating(Rating::new(5, factory(User::class)->create()));
        $book->addRating(Rating::new(3, factory(User::class)->create()));
        $book->addRating(Rating::new(3, factory(User::class)->create()));

        $this->assertNotNull($book->getAuthors()->get(0));
        $this->assertNotNull($book->getGenres()->get(0));
        $this->assertEquals(11, $book->totalRating());
    }
}
