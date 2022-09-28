<?php

/** @var Factory $factory */

use App\Models\Course;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Course::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
    ];
});
