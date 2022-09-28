<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Modules\Questionario\Entities\QuestionarioPagina;

$factory->define(QuestionarioPagina::class, function (Faker $faker) {
    return [
        'questionario_id' => factory(\Modules\Questionario\Entities\Questionario::class),
        'titulo' => $faker->regexify('[A-Za-z0-9]{255}'),
        'subtitulo' => $faker->regexify('[A-Za-z0-9]{255}'),
    ];
});
