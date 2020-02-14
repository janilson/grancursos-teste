<?php

use Illuminate\Database\Seeder;
use Modules\Adesao\Database\Seeders\AdesaoServidorTableSeeder;
use Modules\Adesao\Database\Seeders\AdesaoTableSeeder;
use Modules\Autenticacao\Database\Seeders\UsuarioTableSeeder;
use Modules\Coorporativo\Database\Seeders\MunicipioTableSeeder;
use Modules\Coorporativo\Database\Seeders\UfTableSeeder;
use Modules\Inscricao\Database\Seeders\GrupoTableSeeder;
use Modules\Inscricao\Database\Seeders\ItemTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UfTableSeeder::class);
        $this->call(MunicipioTableSeeder::class);
        $this->call(AdesaoTableSeeder::class);
        $this->call(AdesaoServidorTableSeeder::class);
        $this->call(UsuarioTableSeeder::class);
        $this->call(GrupoTableSeeder::class);
        $this->call(ItemTableSeeder::class);
    }
}
