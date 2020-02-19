<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Modules\GranCursos\Entities\Assunto;

$factory->define(Assunto::class, function (Faker $faker) {
    return [
        'no_assunto' => $faker->firstNameMale . ' ' .  $faker->uuid
    ];
});
