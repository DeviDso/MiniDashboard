<?php

use Faker\Generator as Faker;

$factory->define(App\OrderData::class, function (Faker $faker) {
    $date = $faker->dateTimeThisYear($max = 'now', $timezone = null);
    return [
        'order_id' => $faker->numberBetween($min = 1, $max = 100),
        'product_id' => $faker->numberBetween($min = 1, $max = 100),
        'quantity' => $faker->numberBetween($min = 1, $max = 5),
        'price' => $faker->numberBetween($min = 1, $max = 5000),
        'created_at' => $date,
        'updated_at' => $date,
    ];
});
