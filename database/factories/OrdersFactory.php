<?php

use Faker\Generator as Faker;

$factory->define(App\Order::class, function (Faker $faker) {
    $date = $faker->dateTimeThisYear($max = 'now', $timezone = null);
    return [
        'user_id' => $faker->numberBetween($min = 1, $max = 10),
        'client_id' => $faker->numberBetween($min = 1, $max = 30),
        'status_id' => $faker->numberBetween($min = 1, $max = 12),
        'created_at' => $date,
        'updated_at' => $date,
    ];
});
