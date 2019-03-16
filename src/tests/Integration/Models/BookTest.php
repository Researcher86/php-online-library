<?php

namespace Tests\Integration\Models;

use App\Models\Book\Author;
use App\Models\Book\Book;
use App\Models\Book\Genre;
use App\Models\Book\Image;
use App\Models\Book\Rating;
use App\Models\User;
use Tests\TestCase;

class BookTest extends TestCase
{
    public function testCreate()
    {
        /** @var Book $book */
        $book = factory(Book::class)->create();
        self::assertNotNull($book);

        $book->addAuthor(factory(Author::class)->create());
        $book->addGenre(factory(Genre::class)->create());
        $book->addImage(factory(Image::class)->create());

        $book->addRating(Rating::create(5, factory(User::class)->create()->id));

        self::assertNotNull($book->getAuthors()->get(0));
        self::assertNotNull($book->getGenres()->get(0));
        self::assertNotNull($book->getImages()->get(0));
        self::assertNotNull($book->getRatings()->get(0));
    }

    public function testCalculateRatingAverage()
    {
        /** @var Book $book */
        $book = factory(Book::class)->create();
        self::assertNotNull($book);

        $book->addRating(Rating::create(5, factory(User::class)->create()->id));
        $book->addRating(Rating::create(5, factory(User::class)->create()->id));
        $book->addRating(Rating::create(5, factory(User::class)->create()->id));
        $book->addRating(Rating::create(3, factory(User::class)->create()->id));
        $book->addRating(Rating::create(3, factory(User::class)->create()->id));
        $book->addRating(Rating::create(3, factory(User::class)->create()->id));
        $book->addRating(Rating::create(3, factory(User::class)->create()->id));
        $book->addRating(Rating::create(4, factory(User::class)->create()->id));
        $book->addRating(Rating::create(3, factory(User::class)->create()->id));
        $book->addRating(Rating::create(3, factory(User::class)->create()->id));
        $book->addRating(Rating::create(2, factory(User::class)->create()->id));
        $book->addRating(Rating::create(1, factory(User::class)->create()->id));

        self::assertEquals(3.34, $book->calculateRatingAverage());
    }

}
