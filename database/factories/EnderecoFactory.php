<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Endereco;
use Faker\Generator as Faker;

$factory->define(Endereco::class, function (Faker $faker) {
    return [
        'iptu' => $faker->numberBetween(9877),
        'cep' => $faker->randomElement([18703757, 86010390, 87005030, 87005150, 87010030, 86604298]),
        'logradouro' => $faker->streetName,
        'numero' => $faker->numberBetween(100, 9999),
        'complemento' => $faker->word(),
        'bairro' => $faker->word(),
        'cidade' => 'Maringá',
        'uf' => 'PR',
        'ibge' => 4115200
    ];
});
