<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Empresa;
use Faker\Generator as Faker;

$factory->define(Empresa::class, function (Faker $faker) {
    $empresa = new \Faker\Provider\pt_BR\Company($faker);
    return [
        'inscricao_municipal' => $faker->numberBetween(5, 8),
        'inicio_atividades' => $faker->date('Y-m-d'),
        'regime_tributario' => $faker->randomElement(['SN', 'Presumido']),
        'tipo_societario' => $tipo_societario = $faker->randomElement(['Eireli', 'LTDA', 'Individual', 'Unipessoal']),
        'nome_fantasia' => $empresa->jobTitle(),
        'razao_social' => $empresa->company() . ' ' . $tipo_societario,
        'status_id' => $faker->randomElement(array_keys(Empresa::$status)),
        'data_sn' => $faker->date('Y-m-d'),
        'cnpj' => $empresa->cnpj(false),
    ];
});
