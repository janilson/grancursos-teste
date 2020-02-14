<?php

namespace Modules\Adesao\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Adesao\Entities\Adesao;
use Modules\Adesao\Entities\Servidor;
use Modules\Adesao\Services\AdesaoService;
use Modules\Coorporativo\Entities\Municipio;

class AdesaoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Servidor::query()->delete();
        Adesao::query()->delete();

        Municipio::select()->limit(1000)->get()
            ->each(function (Municipio $municipio) {
                factory(Adesao::class, 1)->make([
                    'co_municipio' => $municipio->co_municipio
                ])->each(function (Adesao $adesao) {
                    $adesao->save();
                });
            });

        /*
         * Municípios Fixos para testes
         * AM - Careiro
         * MS - Bonito
         * MS - Angélica
         */
        Municipio::select()
            ->whereIn('co_ibge', array('1301100', '5002209', '5000856'))
            ->get()
            ->each(function (Municipio $municipio) {
                factory(Adesao::class, 1)->make([
                    'co_municipio' => $municipio->co_municipio
                ])->each(function (Adesao $adesao) {
                    $adesao->save();
                });
            });
    }
}
