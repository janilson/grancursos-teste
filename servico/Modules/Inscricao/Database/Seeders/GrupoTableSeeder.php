<?php

namespace Modules\Inscricao\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class GrupoTableSeeder extends Seeder
{
    const TB_GRUPO = 'tb_grupo';
    const CO_GRUPO = 'co_grupo';
    const DS_GRUPO = 'ds_grupo';
    const NU_PONTUACAO_TOTAL = 'nu_pontuacao_total';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table(self::TB_GRUPO)->insert([
            [self::DS_GRUPO => 'Pré-Requisitos', self::CO_GRUPO => 0]
        ]);

        \DB::table(self::TB_GRUPO)->insert([
            [self::DS_GRUPO => 'Esporte', self::CO_GRUPO => 1]
        ]);

        \DB::table(self::TB_GRUPO)->insert([
            [self::DS_GRUPO => 'Ações Culturais', self::CO_GRUPO => 2]
        ]);

        \DB::table(self::TB_GRUPO)->insert([
            [self::DS_GRUPO => 'Biblioteca e Leitura', self::CO_GRUPO => 3]
        ]);

        \DB::table(self::TB_GRUPO)->insert([
            [self::DS_GRUPO => 'Ações Integradas de Cidadania', self::CO_GRUPO => 4]
        ]);

        \DB::table(self::TB_GRUPO)->insert([
            [self::DS_GRUPO => 'Criança Feliz', self::CO_GRUPO => 5]
        ]);

        \DB::table(self::TB_GRUPO)->insert([
            [self::DS_GRUPO => 'Compras da Agricultura Familiar', self::CO_GRUPO => 6]
        ]);

        \DB::table(self::TB_GRUPO)->insert([
            [self::DS_GRUPO => 'Prevenção às Drogas', self::CO_GRUPO => 7]
        ]);

        \DB::table(self::TB_GRUPO)->insert([
            [self::DS_GRUPO => 'Plano Progredir', self::CO_GRUPO => 8]
        ]);

        \DB::table(self::TB_GRUPO)->insert([
            [self::DS_GRUPO => 'Extra', self::CO_GRUPO => 9]
        ]);


        if (\Schema::hasColumn(self::TB_GRUPO, self::NU_PONTUACAO_TOTAL)) {
            \DB::table(self::TB_GRUPO)
                ->where([self::DS_GRUPO => 'Esporte'])
                ->update([self::NU_PONTUACAO_TOTAL => 15]);

            \DB::table(self::TB_GRUPO)
                ->where([self::DS_GRUPO => 'Ações Culturais'])
                ->update([self::NU_PONTUACAO_TOTAL => 8]);

            \DB::table(self::TB_GRUPO)
                ->where([self::DS_GRUPO => 'Biblioteca e Leitura'])
                ->update([self::NU_PONTUACAO_TOTAL => 2]);

            \DB::table(self::TB_GRUPO)
                ->where([self::DS_GRUPO => 'Ações Integradas de Cidadania'])
                ->update([self::NU_PONTUACAO_TOTAL => 2]);

            \DB::table(self::TB_GRUPO)
                ->where([self::DS_GRUPO => 'Criança Feliz'])
                ->update([self::NU_PONTUACAO_TOTAL => 2]);

            \DB::table(self::TB_GRUPO)
                ->where([self::DS_GRUPO => 'Compras da Agricultura Familiar'])
                ->update([self::NU_PONTUACAO_TOTAL => 3]);

            \DB::table(self::TB_GRUPO)
                ->where([self::DS_GRUPO => 'Prevenção às Drogas'])
                ->update([self::NU_PONTUACAO_TOTAL => 2]);

            \DB::table(self::TB_GRUPO)
                ->where([self::DS_GRUPO => 'Plano Progredir'])
                ->update([self::NU_PONTUACAO_TOTAL => 1]);

            \DB::table(self::TB_GRUPO)
                ->where([self::DS_GRUPO => 'Pré-Requisitos'])
                ->update([self::NU_PONTUACAO_TOTAL => 0]);

            \DB::table(self::TB_GRUPO)
                ->where([self::DS_GRUPO => 'Extra'])
                ->update([self::NU_PONTUACAO_TOTAL => 3]);
        }
    }
}
