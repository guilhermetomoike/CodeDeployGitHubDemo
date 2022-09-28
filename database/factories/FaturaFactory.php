<?php

/** @var Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Modules\Invoice\Entities\Fatura;

$factory->define(Fatura::class, function (Faker $faker) {
    return [
        'subtotal' => $faker->numberBetween(178, 356),
        'data_competencia' => $faker->date('Y-m-01', today()->addMonth()),
        'data_vencimento' => $faker->date('Y-m-d', today()->addMonth()),
        'status' => $faker->randomElement(['cancelado', 'pago', 'pendente', 'atrasado', 'estornado']),
        'data_recebimento' => $faker->date('Y-m-d'),
        'payer_type' => $faker->randomElement(['cliente', 'empresa']),
        'payer_id' => 74,
    ];
});
