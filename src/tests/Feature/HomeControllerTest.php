<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomeControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testHomePage()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('login');
        $response->assertSee('register');
        $response->assertSee('ru');
        $response->assertSee('en');
        $response->assertSee('<home></home>');
    }
}
