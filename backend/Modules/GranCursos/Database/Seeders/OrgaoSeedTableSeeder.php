<?php

namespace Modules\GranCursos\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\GranCursos\Entities\Orgao;

class OrgaoSeedTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Orgao::query()->delete();

        factory(Orgao::class, 10)->create();
    }
}
