<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Contato::class, function (Faker $faker) {
    $tipo = $faker->randomElement(['email', 'celular']);

    $options = $tipo == 'celular' ? ['is_whatsapp' => true] : null;

    return [
        'tipo' => $tipo,
        'value' => $tipo == 'email' ? $faker->email : $faker->phoneNumber,
        'optin' => 1,
        'options' => $options,
    ];
});
