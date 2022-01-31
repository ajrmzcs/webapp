<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CsvData;
use Faker\Generator as Faker;

$factory->define(CsvData::class, function (Faker $faker) {
    return [
        'team_id' => $faker->numberBetween(1,10),
        'name' => $faker->name,
        'phone' => $faker->phoneNumber,
        'email' => $faker->unique()->safeEmail,
        'sticky_phone_number_id' => $faker->numberBetween(1,10),
        'city' => $faker->city,
        'zip' => $faker->postcode,
        'country' => $faker->country,
        'currency' => $faker->currencyCode,
    ];
});
