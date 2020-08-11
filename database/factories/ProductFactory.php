<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    $name = $faker->unique()->words(2, true);
    $name_arr = explode(' ', trim($name));
    return [
        'sku' => substr($name_arr[0], 0, 4) . $faker->randomNumber(4),
        'name' => ucfirst($name),
        'description' => $faker->text(255),
        'image' => $faker->imageUrl(480, 360,'technics'),
        'price' => $faker->randomFloat(2, 5, 1000),
        'stock' => $faker->numberBetween(0, 1000),
        'enabled' => $faker->boolean,
        'notes' => $faker->text(50),
    ];
});
