<?php

namespace Modules\Coorporativo\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CoorporativoDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UfTableSeeder::class);
        $this->call(MunicipioTableSeeder::class);
    }
}
