<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Faturamento;
use Faker\Generator as Faker;

$factory->define(Faturamento::class, function (Faker $faker) {
    return [
        'faturamento' => $faker->numberBetween(1600, 50000),
        'mes' => $faker->randomElement([
            $faker->date('Y-m-01'),
            date('Y-m-01'),
            today()->subMonth()->format('Y-m-01'),
            today()->subMonth()->format('Y-m-01'),
            today()->subMonth()->format('Y-m-01'),
            today()->subMonth()->format('Y-m-01'),
            today()->subMonths(2)->format('Y-m-01'),
            today()->subMonths(5)->format('Y-m-01'),
            today()->subMonths(6)->format('Y-m-01'),
            today()->subMonths(3)->format('Y-m-01')
        ]),
    ];
});
