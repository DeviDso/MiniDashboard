<?php

use Faker\Generator as Faker;

$factory->define(App\Client::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->phoneNumber,
        'city' => $faker->city,
        'street' => $faker->streetAddress,
        'post_code' => $faker->postcode,
        'country' => $faker->country,
        'contact_person' => $faker->firstName($gender = null),
    ];
});
