<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Feedback;
use Faker\Generator as Faker;

$factory->define(Feedback::class, function (Faker $faker) {
    return [
      'email' => $faker->email,
      'rate' => rand(1,5),
      'name' => $faker->name,
      'comment' => $faker->sentence($nbWords = rand(0, 30), $variableNbWords = true),
    ];
});
