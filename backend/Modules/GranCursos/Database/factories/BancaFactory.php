<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Modules\GranCursos\Entities\Banca;

$factory->define(Banca::class, function (Faker $faker) {
    return [
        'no_banca' => $faker->firstNameFemale . ' ' .  $faker->uuid
    ];
});
