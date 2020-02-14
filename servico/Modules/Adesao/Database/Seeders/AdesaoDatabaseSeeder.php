<?php

namespace Modules\Adesao\Database\Seeders;

use Illuminate\Database\Seeder;

class AdesaoDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdesaoTableSeeder::class);
        $this->call(AdesaoServidorTableSeeder::class);
    }
}
