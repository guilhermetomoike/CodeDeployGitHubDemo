<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Modules\Questionario\Entities\QuestionarioParte;

$factory->define(QuestionarioParte::class, function (Faker $faker) {
    return [
        'questionario_pagina_id' => factory(\Modules\Questionario\Entities\QuestionarioPagina::class),
        'titulo' => $faker->regexify('[A-Za-z0-9]{255}'),
        'subtitulo' => $faker->regexify('[A-Za-z0-9]{255}'),
        'url_imagem' => $faker->regexify('[A-Za-z0-9]{512}'),
    ];
});
