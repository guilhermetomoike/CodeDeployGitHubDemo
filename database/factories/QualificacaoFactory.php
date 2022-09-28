<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Qualificacao;
use Faker\Generator as Faker;

$factory->define(Qualificacao::class, function (Faker $faker) {
    return [
        'nome' => $faker->words(2, true)
    ];
});
