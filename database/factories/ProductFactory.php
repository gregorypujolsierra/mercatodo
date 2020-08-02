<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    $name = $faker->unique()->word;
    return [
        'sku' => 'MT-' . strtoupper($name) . '-' . $faker->randomNumber(4),
        'name' => ucfirst($name),
        'description' => $faker->text(255),
        'price' => $faker->randomFloat(2, 5, 1000),
        'stock' => $faker->numberBetween(0, 1000),
        'enabled' => $faker->boolean,
        'notes' => $faker->text(100),
    ];
});
