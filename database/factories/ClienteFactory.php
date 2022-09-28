<?php

/** @var Factory $factory */

use App\Models\Cliente;
use Faker\Generator as Faker;
use Faker\Provider\pt_BR\Person;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Cliente::class, function (Faker $faker) {
    $person = new Person($faker);
    return [
        'nome_completo' => $person->name(),
        'cpf' => $cpf = $person->cpf(false),
        'rg' => $person->rg(false),
        'data_nascimento' => $faker->dateTimeBetween('- 40 years', '- 20 years')->format('Y-m-d'),
        'sexo' => $faker->randomElement(['M', 'F']),
        'nacionalidade' => 'Brasileiro',
        'profissao_id' => $faker->numberBetween(1, 20),
        'qualificacao_id' => $faker->numberBetween(1, 5),
        'especialidade_id' => $faker->numberBetween(1, 20),
        'senha' => $cpf
    ];
});
