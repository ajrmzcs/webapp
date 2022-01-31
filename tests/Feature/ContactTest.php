<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    public $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    public function test_an_unauthenticated_user_cannot_import_contacts()
    {
        $response = $this->json('post', '/import', [
            'contacts' => $this->contacts,
            'columns' => $this->columns,
        ]);

        $response->assertStatus(401);
        $this->assertEquals(
            'Unauthenticated.',
            json_decode($response->getContent(), true)['message']
        );
    }

    public function test_an_authenticated_user_can_import_contacts()
    {
        $response = $this->actingAs($this->user)->json('post', '/import', [
            'contacts' => $this->contacts,
            'columns' => $this->columns,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseCount('contacts', 2);
        $this->assertDatabaseCount('custom_attributes', 8);
    }

    public function test_it_return_error_on_invalid_request()
    {
        $response = $this->actingAs($this->user)->json('post', '/import', [
            'contacts' => $this->contacts,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['columns']);
    }

    public function test_an_unauthenticated_user_cannot_get_contacts()
    {
        $response = $this->json('get', '/show-records');

        $response->assertStatus(401);
        $this->assertEquals(
            'Unauthenticated.',
            json_decode($response->getContent(), true)['message']
        );
    }

    public function test_an_authenticated_user_can_get_contacts()
    {
        $this->actingAs($this->user)->json('post', '/import', [
            'contacts' => $this->contacts,
            'columns' => $this->columns,
        ]);

        $response = $this->actingAs($this->user)->json('get', '/records');
        $responseData = json_decode($response->getContent(), true);

        $response->assertStatus(200);
        $this->assertEquals(2, count($responseData['data']));
        $this->stringContains($this->contacts[1]['column-2'], $response->getContent());
    }
}
