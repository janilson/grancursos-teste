<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\Modules\Adesao\Entities\Servidor::class, function (Faker $faker) {
    return [
        "nu_cpf" => $faker->randomNumber(5) . $faker->randomNumber(6),
        "no_servidor" => $faker->name,
        "ds_email" => $faker->email,
        "nu_telefone" => substr($faker->phoneNumber, 0, 11),
        "no_funcao" => $faker->jobTitle,
        "no_lotacao" => $faker->company,
        "st_coordenador" => 'N',
    ];
});
