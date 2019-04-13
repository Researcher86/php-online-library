<?php

namespace Tests\Integration\Models;

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
        self::assertTrue(Rating::checkExists(1, 2));
        self::assertFalse(Rating::checkExists(1, 210));
    }


    public function providerInvalidData()
    {
        return [
            [-1.0],
            [0.4],
            [6.5],
            [7.1],
        ];
    }

    public function providerValidData()
    {
        return array(
            [1.1],
            [2.2],
            [3.3],
            [4.4],
            [5.0],
        );
    }
}
