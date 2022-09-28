<?php

/** @var Factory $factory */

use App\Models\Especialidade;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Especialidade::class, function (Faker $faker) {
    return [
        'nome' => $faker->words(2, true)
    ];
});
