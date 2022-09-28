<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Estado;
use App\Models\JuntaComercial;
use Faker\Generator as Faker;

$factory->define(JuntaComercial::class, function (Faker $faker) {
    return [
        'estado_id' => Estado::all()->first()->id,
        'taxa_alteracao' => $faker->randomFloat(2, 0, 999999.99),
        'taxa_alteracao_extra' => $faker->randomFloat(2, 0, 999999.99),
    ];
});
