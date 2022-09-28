<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Modules\Onboarding\Entities\Onboarding;

$factory->define(Onboarding::class, function (Faker $faker) {
    return [
        'nome' => $faker->sentence(3, false),
        'tipo_id' => 1,
    ];
});
