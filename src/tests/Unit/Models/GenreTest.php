<?php

namespace Tests\Unit\Models;

use App\Models\Book;
use App\Models\Genre;
use Tests\TestCase;

class GenreTest extends TestCase
{
    public function testCreate()
    {
        $genre = factory(Genre::class)->create();
        self::assertNotNull($genre);
    }

    public function testFindByGenre()
    {
        Book::findOrFail(1)->addGenre(Genre::findOrFail(2));
        Book::findOrFail(2)->addGenre(Genre::findOrFail(2));

        $books = Genre::findOrFail(2)->books()->paginate(8);
        self::assertNotNull($books);
        self::assertEquals(2, $books->count());
    }

}
