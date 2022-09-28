<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Modules\EmpresaAlteracao\Entities\EmpresaAlteracao;

$factory->define(EmpresaAlteracao::class, function (Faker $faker) {
    return [
        'nome' => $faker->word,
    ];
});
