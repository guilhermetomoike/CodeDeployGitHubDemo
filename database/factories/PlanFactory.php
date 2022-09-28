<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Modules\Plans\Entities\Plan;

$factory->define(Plan::class, function (Faker $faker) {
    return [
        'name' => $faker->text(40),
        'description' => $faker->text(40),
        'price' => $faker->numberBetween(150, 400),
    ];
});
