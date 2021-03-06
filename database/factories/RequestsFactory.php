<?php

use Faker\Generator as Faker;

$factory->define(App\ClientRequest::class, function (Faker $faker) {
    $date = $faker->dateTimeThisYear($max = 'now', $timezone = null);
    return [
        'user_id' => $faker->numberBetween($min = 1, $max = 10),
        'client_id' => $faker->numberBetween($min = 1, $max = 30),
        'request_type_id' => $faker->numberBetween($min = 1, $max = 4),
        'request_status_id' => $faker->numberBetween($min = 1, $max = 3),
        'note' => $faker->text($maxNbChars = 200),
        'created_at' => $date,
        'updated_at' => $date,
    ];
});
