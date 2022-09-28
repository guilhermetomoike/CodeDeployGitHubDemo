<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Modules\Questionario\Entities\Questionario;

$factory->define(Questionario::class, function (Faker $faker) {
    return [
        'titulo' => $faker->regexify('[A-Za-z0-9]{255}'),
        'subtitulo' => $faker->regexify('[A-Za-z0-9]{255}'),
    ];
});
