<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\CartaoCredito;
use Faker\Generator as Faker;

$factory->define(CartaoCredito::class, function (Faker $faker) {
    $date = today()->addYear();
    return [
        'token_cartao' => md5($faker->word()),
        'ano' => $date->year,
        'mes' => $date->month,
        'cartao_truncado' => 'XXXX-XXXX-XXXX-' . $faker->numberBetween(1111, 9999),
        'dono_cartao' => $faker->name(),
        'forma_pagamento_gatway_id' => md5($faker->word()),
    ];
});
