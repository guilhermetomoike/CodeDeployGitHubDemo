<?php

use Faker\Generator as Faker;
use Modules\Apontamentos\Entities\Apontamento;

$factory->define(Apontamento::class, function (Faker $faker) {
    return [
        'nome' => $faker->word(),
        'sla' => $faker->numberBetween(1, 50)
    ];
});
