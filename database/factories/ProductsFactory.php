<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'category_id' => $faker->numberBetween($min = 1, $max = 10),
        'name' => $faker->word,
        'code' => $faker->unique()->numberBetween($min =  10000, $max = 99999),
        'alternative_code' => 'AC' . $faker->unique()->numberBetween($min = 10000, $max = 99999),
        'bruto' => $bruto = $faker->numberBetween($minx = 1, $max = 999),
        'netto' => $faker->numberBetween($minx = 1, $max = $bruto),
        'quantity' => $faker->numberBetween(1, 20),
        'price' => $faker->numberBetween($min = 100, $max = 5000),
        'warehouse' => $faker->numberBetween($min = 1, $max = 2),
        'warehouse_location' => $faker->randomLetter . $faker->numberBetween($min = 1, $max = 10),
        'description' => $faker->text($maxNbChars = 200),
        'note' => $faker->text($maxNbChars = 50),
    ];
});
