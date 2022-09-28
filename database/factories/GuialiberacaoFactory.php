<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\GuiaLiberacao;
use Faker\Generator as Faker;

$factory->define(GuiaLiberacao::class, function (Faker $faker) {
    $competencias = [
        $faker->date('Y-m-01'),
        date('Y-m-01'),
        today()->subMonth()->format('Y-m-01'),
        today()->subMonth()->format('Y-m-01'),
        today()->subMonths(2)->format('Y-m-01'),
        today()->subMonths(5)->format('Y-m-01'),
        today()->subMonths(6)->format('Y-m-01'),
        today()->subMonths(3)->format('Y-m-01')
    ];

    return [
        'competencia' => $faker->randomElement($competencias),
        'financeiro_departamento_liberacao' => 1,
        'rh_departamento_liberacao' => 1,
        'contabilidade_departamento_liberacao' => 1,
    ];
});
