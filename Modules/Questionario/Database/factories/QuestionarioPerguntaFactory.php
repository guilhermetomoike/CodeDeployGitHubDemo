<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Modules\Questionario\Entities\QuestionarioPergunta;

$factory->define(QuestionarioPergunta::class, function (Faker $faker) {
    return [
        'questionario_parte_id' => factory(\Modules\Questionario\Entities\QuestionarioParte::class),
        'titulo' => $faker->regexify('[A-Za-z0-9]{512}'),
        'subtitulo' => $faker->regexify('[A-Za-z0-9]{512}'),
        'url_imagem' => $faker->regexify('[A-Za-z0-9]{512}'),
        'obrigatoria' => $faker->boolean,
        'tipo' => $faker->randomElement(["me","ue","tl","tc","dt","nu","vl","in","or"]),
        'tipo_escolha' => $faker->randomElement(["hz","vt","cb"]),
        'min' => $faker->numberBetween(-10000, 10000),
        'max' => $faker->numberBetween(-10000, 10000),
        'mostrar_se_resposta' => $faker->regexify('[A-Za-z0-9]{512}'),
        'mostrar_se_pergunta_id' => factory(\Modules\Questionario\Entities\QuestionarioPergunta::class),
    ];
});
