<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Guia;
use Faker\Generator as Faker;

$factory->define(Guia::class, function (Faker $faker) {
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
    $vencimentos = [
        $faker->date('Y-m-d'),
        date('Y-m-d'),
        today()->subMonth()->format('Y-m-' . rand(6, 22)),
        today()->subMonth()->format('Y-m-' . rand(6, 22)),
        today()->addDays(20)->format('Y-m-' . rand(6, 22)),
        today()->subMonths(20)->format('Y-m-' . rand(6, 22)),
        today()->subMonths(5)->format('Y-m-' . rand(6, 22)),
        today()->addDays(5)->format('Y-m-' . rand(6, 22)),
        today()->subMonths(6)->format('Y-m-' . rand(6, 22)),
        today()->subMonths(3)->format('Y-m-' . rand(6, 22)),
    ];

    $tipo = $faker->randomElement(Guia::TIPOS);

    return [
        'tipo' => $tipo,
        'data_vencimento' => $faker->randomElement($vencimentos),
        'data_competencia' => $faker->randomElement($competencias),
        'nome_guia' => implode('_', $faker->words()) . '.pdf',
        'valor' => [strtolower(explode('/', $tipo)[0]) => $faker->numberBetween(40, 999)],
    ];
});
