<?php

namespace Modules\Adesao\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Adesao\Entities\Adesao;
use Modules\Adesao\Entities\Servidor;
use Modules\Coorporativo\Entities\Municipio;

class AdesaoServidorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arCoIbge = [
            '1301100' => '87893963166',
            '5002209' => '27118387223',
            '5000856' => '97558427720'
            ];

        $municipios = array_values(Municipio::select('co_municipio')
            ->whereIn('co_ibge', array_keys($arCoIbge))
            ->get()
            ->toArray());

        Adesao::select()
            ->whereNotIn('co_municipio', $municipios)
            ->get()
            ->each(function (Adesao $adesao) {
                factory(Servidor::class, 3)
                    ->make()
                    ->each(function (Servidor $servidor) use ($adesao) {
                        $servidor->co_adesao = $adesao->co_adesao;
                        $servidor->save();
                    });
            });

        Adesao::select()
            ->whereIn('co_municipio', $municipios)
            ->get()
            ->each(function (Adesao $adesao) use ($arCoIbge) {
                factory(Servidor::class, 1)
                    ->make()
                    ->each(function (Servidor $servidor) use ($adesao, $arCoIbge) {
                        $servidor->co_adesao = $adesao->co_adesao;
                        $servidor->nu_cpf = $arCoIbge[$adesao->municipio->co_ibge];
                        $servidor->save();
                    });
            });
    }
}
