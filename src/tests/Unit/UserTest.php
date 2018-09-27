<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

//use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
//    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreate()
    {
        $user = factory(User::class)->create();
        $this->assertNotNull($user);

        $this->assertTrue(true);
    }
}
