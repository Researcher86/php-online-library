<?php

namespace Tests\Unit\Models;

use App\Models\Rating;
use App\Models\User;
use Tests\TestCase;

class RatingTest extends TestCase
{
    /**
     * @dataProvider providerInvalidData
     */
    public function testCreateInvalidRating()
    {
        foreach (func_get_args() as $number) {
            $this->expectException(\DomainException::class);
            $this->expectExceptionMessage(sprintf('Rating is not included in the range %d..%d', Rating::MIN, Rating::MAX));
            Rating::create($number, factory(User::class)->create()->id);
        }
    }

    /**
     * @dataProvider providerValidData
     */
    public function testCreateValidRating()
    {
        foreach (func_get_args() as $number) {
            $rating = Rating::create($number, factory(User::class)->create()->id);
            $this->assertNotNull($rating);
            $this->assertNotNull($rating->user);
        }
    }

    public function providerInvalidData()
    {
        return [
            [-1, 0, 6, 7],
        ];
    }

    public function providerValidData()
    {
        return [
            [1, 2, 3, 4, 5],
        ];
    }
}
