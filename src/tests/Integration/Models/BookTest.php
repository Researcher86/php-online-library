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

        self::assertNotNull($book->getAuthorsNames());
        self::assertNotNull($book->getGenresNames());
        self::assertNotNull($book->getImagesFiles());
        self::assertEquals(5, $book->calculateRatingAverage());
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

    public function testGetGenres()
    {
        /** @var Book $book */
        $book = factory(Book::class)->create();
        self::assertNotNull($book);

        $book->addGenre(factory(Genre::class)->create());
        $book->addGenre(factory(Genre::class)->create());

        self::assertNotNull($book->getGenres());
    }


}
