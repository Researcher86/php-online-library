<?php

namespace Tests\Integration\Models;

use App\Models\Book\Book;
use App\Models\Book\Rating;
use App\Models\User;
use Tests\TestCase;

class RatingTest extends TestCase
{
    /**
     * @dataProvider providerInvalidData
     */
    public function testCreateInvalidRating($number)
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage(sprintf('Rating %.2f is not included in the range %.2f..%.2f', $number, Rating::MIN, Rating::MAX));
        Rating::create($number, factory(User::class)->create()->id);
    }

    /**
     * @dataProvider providerValidData
     */
    public function testCreateValidRating($number)
    {
        $rating = Rating::create($number, factory(User::class)->create()->id);
        $this->assertNotNull($rating);
        $this->assertNotNull($rating->user);
    }

    public function testCheckExists()
    {
        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        Book::findOrFail(1)->addRating(Rating::create(Rating::MAX, $user->id));

        self::assertTrue(Rating::checkExists(1, $user->id));
        self::assertFalse(Rating::checkExists(1, $user2->id));
    }


    public function providerInvalidData()
    {
        return [
            'One' => [-1.0],
            'Two' => [0.4],
            'Three' => [6.5],
            'Four' => [7.1],
        ];
    }

    public function providerValidData()
    {
        return [
            'One' => [1.1],
            'Two' => [2.2],
            'Three' => [3.3],
            'Four' => [4.4],
            'Five' => [5.0],
        ];
    }
}
