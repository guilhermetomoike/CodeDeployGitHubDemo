<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Modules\Questionario\Entities\QuestionarioResposta;
use Modules\Questionario\Entities\QuestionarioPerguntum;

$factory->define(QuestionarioResposta::class, function (Faker $faker) {
    return [
        'questionario_pergunta_id' => factory(QuestionarioPerguntum::class),
        'questionario_pergunta_escolha_id' => factory(\Modules\Questionario\Entities\QuestionarioPerguntaEscolha::class),
        'respondente' => $faker->regexify('[A-Za-z0-9]{255}'),
        'resposta' => $faker->regexify('[A-Za-z0-9]{512}'),
    ];
});
