<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Ies;
use Faker\Generator as Faker;

$factory->define(Ies::class, function (Faker $faker) {
    return [
        'nome' => $faker->word,
        'estado' => $faker->randomElement(['RO', 'AC', 'AM', 'RR', 'PA', 'AP', 'TO', 'MA', 'PI', 'CE', 'RN', 'PB', 'PE', 'AL', 'SE', 'BA', 'MG', 'ES', 'RJ', 'SP', 'PR', 'SC', 'RS', 'MS', 'MT', 'GO', 'DF']),
        'faculdade' => $faker->words(3, true),
    ];
});
