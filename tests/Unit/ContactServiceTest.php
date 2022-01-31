<?php

namespace Tests\Unit;

use App\Services\ContactService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactServiceTest extends TestCase
{

    use RefreshDatabase;

    public function test_it_stores_mapped_data_in_db()
    {
        $response = ContactService::store($this->contacts, $this->columns);

        $this->assertEquals(true, $response['success']);
        $this->assertDatabaseCount('contacts', 2);
        $this->assertDatabaseCount('custom_attributes', 8);
        $this->assertDatabaseHas('contacts', [
            'team_id' => '1',
            'name' => 'Susanna Kirlin',
            'phone' => '+1.703.676.3129',
            'email' => 'marie.stroman@example.org',
            'sticky_phone_number_id' => '4',
        ]);
        $this->assertDatabaseHas('custom_attributes', [
            'contact_id' => '2',
            'key' => 'city',
            'value' => 'South Dominique',
        ]);
        $this->assertDatabaseHas('custom_attributes', [
            'contact_id' => '2',
            'key' => 'country',
            'value' => 'Grenada',
        ]);
    }

    public function test_it_stores_mapped_data_in_db_with_some_attributes()
    {
        unset($this->columns['column-8']);
        unset($this->columns['column-9']);

        $response = ContactService::store($this->contacts, $this->columns);

        $this->assertEquals(true, $response['success']);
        $this->assertDatabaseCount('contacts', 2);
        $this->assertDatabaseCount('custom_attributes', 4);
        $this->assertDatabaseHas('contacts', [
            'team_id' => '1',
            'name' => 'Susanna Kirlin',
            'phone' => '+1.703.676.3129',
            'email' => 'marie.stroman@example.org',
            'sticky_phone_number_id' => '4',
        ]);
        $this->assertDatabaseHas('custom_attributes', [
            'contact_id' => '2',
            'key' => 'city',
            'value' => 'South Dominique',
        ]);
        $this->assertDatabaseMissing('custom_attributes', [
            'contact_id' => '2',
            'key' => 'country',
            'value' => 'Grenada',
        ]);
    }

    public function test_it_fails_when_contacts_table_columns_are_missing()
    {
        unset($this->contacts[0]['column-1']);
        unset($this->columns['column-1']);

        $response = ContactService::store($this->contacts, $this->columns);

        $this->assertEquals(false, $response['success']);
    }
}
