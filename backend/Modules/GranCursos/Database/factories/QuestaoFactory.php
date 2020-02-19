<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Modules\GranCursos\Entities\Questao;

$factory->define(Questao::class, function (Faker $faker) {
    return [
        'no_questao' => $faker->streetName . ' ' .  $faker->uuid
    ];
});
