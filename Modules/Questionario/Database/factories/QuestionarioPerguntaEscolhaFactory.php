<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Modules\Questionario\Entities\QuestionarioPerguntum;
use Modules\Questionario\Entities\QuestionarioPerguntaEscolha;

$factory->define(QuestionarioPerguntaEscolha::class, function (Faker $faker) {
    return [
        'questionario_pergunta_id' => factory(QuestionarioPerguntum::class),
        'escolha' => $faker->regexify('[A-Za-z0-9]{512}'),
        'tipo' => $faker->randomElement(["tx","im","bt"]),
        'outro_informar' => $faker->boolean,
        'mostrar_se_resposta' => $faker->regexify('[A-Za-z0-9]{512}'),
        'mostrar_se_pergunta_id' => factory(\Modules\Questionario\Entities\QuestionarioPergunta::class),
    ];
});
