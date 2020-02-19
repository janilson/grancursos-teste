<?php

namespace Modules\GranCursos\Database\Seeders;

use Illuminate\Database\Seeder;

class GranCursosDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(
            [
                AssuntoSeedTableSeeder::class,
                BancaSeedTableSeeder::class,
                OrgaoSeedTableSeeder::class,
                QuestaoSeedTableSeeder::class
            ]);
    }
}
