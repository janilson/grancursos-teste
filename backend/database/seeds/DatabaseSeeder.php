<?php

use Illuminate\Database\Seeder;
use Modules\GranCursos\Database\Seeders\GranCursosDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([GranCursosDatabaseSeeder::class]);
    }
}
