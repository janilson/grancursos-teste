<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\Modules\Adesao\Entities\Adesao::class, function (Faker $faker) {
    return [
        "no_prefeito" => $faker->name,
    ];
});
