<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\EmpresaPreCadastro;
use App\Models\Usuario;
use Faker\Generator as Faker;

$factory->define(EmpresaPreCadastro::class, function (Faker $faker) {
    $usuarioId = Usuario::all()->random()->id;

    return [
        'tipo' => $faker->randomElement(['abertura', 'transferencia']),
        'empresa' => ['razao_social' => ['Razao Social 1', 'Razao Social 2', 'Razao Social 3']],
        'usuario_id' => $usuarioId,
    ];
});
