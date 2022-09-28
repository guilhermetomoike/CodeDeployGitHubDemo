<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Carteira::class, function (Faker $faker) {
    return [
        'nome' => 'carteira' . $faker->randomElement([1, 2, 3]),
        'setor' => $faker->randomElement(['rh', 'contabilidade']),
    ];
});
