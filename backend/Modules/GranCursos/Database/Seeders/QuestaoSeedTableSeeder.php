<?php

namespace Modules\GranCursos\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\GranCursos\Entities\Assunto;
use Modules\GranCursos\Entities\Banca;
use Modules\GranCursos\Entities\Orgao;
use Modules\GranCursos\Entities\Questao;

class QuestaoSeedTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arAssunto = [];
        // Assunto Pai
        Assunto::select()
            ->whereNull('id_assunto_pai')
            ->get()
            ->each(function (Assunto $assunto) use (&$arAssunto) {
                $arAssunto[] = $assunto->id_assunto;
            });

        $arBanca = [];
        Banca::all()
            ->each(function (Banca $banca) use (&$arBanca) {
                $arBanca[] = $banca->id_banca;
            });

        $arOrgao = [];
        Orgao::all()
            ->each(function (Orgao $orgao) use (&$arOrgao) {
                $arOrgao[] = $orgao->id_orgao;
            });

        foreach ($arAssunto as $id_assunto) {
            foreach ($arBanca as $id_banca) {
                foreach ($arOrgao as $id_orgao) {
                    factory(Questao::class, rand(1, 3))->make([
                        'id_assunto' => $id_assunto,
                        'id_banca' => $id_banca,
                        'id_orgao' => $id_orgao,
                    ])->each(function (Questao $questao) {
                        $questao->save();
                    });
                }
            }
        }

        $arAssunto = [];

        // Assunto Filho
        Assunto::select()
            ->whereNotNull('id_assunto_pai')
            ->get()
            ->each(function (Assunto $assunto) use (&$arAssunto) {
                $arAssunto[] = $assunto->id_assunto;
            });

        foreach ($arAssunto as $id_assunto) {
            foreach ($arBanca as $id_banca) {
                foreach ($arOrgao as $id_orgao) {
                    factory(Questao::class, rand(1, 2))->make([
                        'id_assunto' => $id_assunto,
                        'id_banca' => $id_banca,
                        'id_orgao' => $id_orgao,
                    ])->each(function (Questao $questao) {
                        $questao->save();
                    });
                }
            }
        }
    }
}
