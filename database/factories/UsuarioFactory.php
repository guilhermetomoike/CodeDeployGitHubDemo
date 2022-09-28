<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Usuario;
use Faker\Generator as Faker;

$factory->define(Usuario::class, function (Faker $faker) {
    return [
        'usuario' => $faker->userName,
        'nome_completo' => $faker->name,
        'senha' => 'senha',
        'email' => $faker->email,
    ];
});
