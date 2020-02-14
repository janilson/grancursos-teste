<?php

namespace Modules\Inscricao\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class InscricaoDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(GrupoTableSeeder::class);
        $this->call(ItemTableSeeder::class);
    }
}
