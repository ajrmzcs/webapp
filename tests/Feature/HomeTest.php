<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    public $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    public function test_an_unauthenticated_user_is_redirected_to_login_page()
    {
        $response = $this->get('/');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function test_an_authenticated_user_sees_home_page()
    {
        $response = $this->actingAs($this->user)->get('/');
        $response->assertStatus(200);
        $response->assertViewIs('home');
    }

    public function test_an_authenticated_user_sees_records_page()
    {
        $response = $this->actingAs($this->user)->get('/show-records');
        $response->assertStatus(200);
        $response->assertViewIs('show-records');

    }
}
