<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Profissao;
use Faker\Generator as Faker;

$factory->define(Profissao::class, function (Faker $faker) {
    return [
        'nome' => $faker->jobTitle
    ];
});
