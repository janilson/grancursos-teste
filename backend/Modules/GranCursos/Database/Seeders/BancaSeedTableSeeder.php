<?php

namespace Modules\GranCursos\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\GranCursos\Entities\Banca;

class BancaSeedTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Banca::query()->delete();

        factory(Banca::class, rand(3, 6))->create();
    }
}
