<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Modules\Onboarding\Entities\OnboardingItem;

$factory->define(OnboardingItem::class, function (Faker $faker) {
    return [
        'nome' => $faker->sentence(8, false),
    ];
});
