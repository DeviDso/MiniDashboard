<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'category_id' => $faker->numberBetween($min = 1, $max = 10),
        'name' => $faker->word,
        'code' => $faker->unique()->numberBetween($min =  10000, $max = 99999),
        'alternative_code' => 'AC' . $faker->unique()->numberBetween($min = 10000, $max = 99999),
        'weight' => $faker->numberBetween($minx = 1, $max = 999),
        'quantity' => $faker->numberBetween(1, 20),
        'price' => $faker->numberBetween($min = 100, $max = 5000),
        'description' => $faker->text($maxNbChars = 200),
    ];
});
