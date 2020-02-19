<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Modules\GranCursos\Entities\Orgao;

$factory->define(Orgao::class, function (Faker $faker) {
    return [
        'no_orgao' => $faker->company . ' ' .  $faker->uuid
    ];
});
