<?php

use Faker\Generator as Faker;

$factory->define(App\ClientRequest::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween($min = 1, $max = 21),
        'client_id' => $faker->numberBetween($min = 1, $max = 68),
        'request_type_id' => $faker->numberBetween($min = 1, $max = 4),
        'request_status_id' => $faker->numberBetween($min = 1, $max = 3),
        'note' => $faker->text($maxNbChars = 200),
    ];
});
