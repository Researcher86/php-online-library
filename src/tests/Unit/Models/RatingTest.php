<?php

namespace Tests\Unit\Models;

use App\Models\Rating;
use App\Models\User;
use Tests\TestCase;

class RatingTest extends TestCase
{
    public function testCreateInvalidRating_zero()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage(sprintf('Rating is not included in the range %d..%d', Rating::MIN, Rating::MAX));

        Rating::create(0, factory(User::class)->create());
    }

    public function testCreateInvalidRating_six()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage(sprintf('Rating is not included in the range %d..%d', Rating::MIN, Rating::MAX));

        Rating::create(6, factory(User::class)->create());
    }

    public function testCreateValidRating_one()
    {
        $rating = Rating::create(1, factory(User::class)->create());
        $this->assertNotNull($rating);
    }

    public function testCreateValidRating()
    {
        $rating = Rating::create(5, factory(User::class)->create());
        $this->assertNotNull($rating);
        $this->assertNotNull($rating->user);
    }

    public function testCreateValidRating_five()
    {
        $rating = Rating::create(5, factory(User::class)->create());
        $this->assertNotNull($rating);
    }
}
