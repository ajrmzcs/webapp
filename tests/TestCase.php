<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public $contacts;

    public $columns;

    public function setUp(): void
    {
        parent::setUp();

        $this->contacts = [
            [
                'column-1' => '3',
                'column-2' => 'Mortimer Waters',
                'column-3' => '986-526-3471',
                'column-4' => 'pherman@example.net',
                'column-5' => '3',
                'column-6' => 'Lauriannemouth',
                'column-7' => '49381',
                'column-8' => 'Anguilla',
                'column-9' => 'BDT',
            ],
            [
                'column-1' => '1',
                'column-2' => 'Susanna Kirlin',
                'column-3' => '+1.703.676.3129',
                'column-4' => 'marie.stroman@example.org',
                'column-5' => '4',
                'column-6' => 'South Dominique',
                'column-7' => '79228-5155',
                'column-8' => 'Grenada',
                'column-9' => 'CDF',
            ],
        ];

        $this->columns = [
            'column-1' => 'team_id',
            'column-2' => 'name',
            'column-3' => 'phone',
            'column-4' => 'email',
            'column-5' => 'sticky_phone_number_id',
            'column-6' => 'city',
            'column-7' => 'zip',
            'column-8' => 'country',
            'column-9' => 'currency',
        ];
    }
}
