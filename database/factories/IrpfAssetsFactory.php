<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\IrpfAssets;
use Faker\Generator as Faker;

$factory->define(IrpfAssets::class, function (Faker $faker) {
    return [
        'code' => $faker->numberBetween(10, 90),
        'description' => $faker->text(80),
        'value' => $faker->numberBetween(5000, 150000),
    ];
});
