<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Plate;
use Faker\Generator as Faker;

$factory->define(Plate::class, function (Faker $faker) {
    return [
      'plate_name' => $faker->word,
      'ingredients' => $faker->sentence($nbWords = rand(2, 10), $variableNbWords = true),
      'description' => $faker->sentence($nbWords = rand(0, 20), $variableNbWords = true),
      'price' => rand(100,3000),
      'visible' => rand(0,1),
      'discount' => Plate::getDiscount(),
      'availability' => Plate::getAvail(),
      // 'img'
    ];
});
