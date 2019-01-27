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
        self::assertNotNull($book);

        $book->addAuthors(factory(Author::class)->create());
        $book->addGenre(factory(Genre::class)->create());

        $book->addRating(Rating::create(5, factory(User::class)->create()->id));
        $book->addRating(Rating::create(3, factory(User::class)->create()->id));
        $book->addRating(Rating::create(3, factory(User::class)->create()->id));

        self::assertNotNull($book->getAuthors()->get(0));
        self::assertNotNull($book->getGenres()->get(0));
        self::assertEquals(11, $book->totalRating());
    }

}
