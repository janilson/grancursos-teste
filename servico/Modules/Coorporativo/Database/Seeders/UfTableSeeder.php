<?php

Namespace Modules\Coorporativo\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class UfTableSeeder extends Seeder
{
    const CO_UF = 'CO_UF';
    const NO_UF = 'NO_UF';
    const SG_UF = 'SG_UF';

    const NO_REGIAO = 'no_regiao';
    const TB_UF = 'tb_uf';

    const REGIOES = [
      1 => 'Norte',
      2 => 'Nordeste',
      3 => 'Centro-Oeste',
      4 => 'Sudeste',
      5 => 'Sul'
    ];

    /**
     *
     */
    public function run()
    {
        \DB::table('TB_ADESAO_SERVIDOR')->delete();
        \DB::table('TB_ADESAO')->delete();
        \DB::table('TB_MUNICIPIO')->delete();
        \DB::table('tb_uf')->delete();

        $existeColunaRegiao = Schema::hasColumn(self::TB_UF, self::NO_REGIAO);

        if ($existeColunaRegiao) {
            \DB::table(self::TB_UF)->insert([
                [self::NO_UF => 'Acre', self::SG_UF => 'AC', self::NO_REGIAO => self::REGIOES[1]],
                [self::NO_UF => 'Alagoas', self::SG_UF => 'AL', self::NO_REGIAO => self::REGIOES[2]],
                [self::NO_UF => 'Amapá', self::SG_UF => 'AP', self::NO_REGIAO => self::REGIOES[1]],
                [self::NO_UF => 'Amazonas', self::SG_UF => 'AM', self::NO_REGIAO => self::REGIOES[1]],
                [self::NO_UF => 'Bahia', self::SG_UF => 'BA', self::NO_REGIAO => self::REGIOES[2]],
                [self::NO_UF => 'Ceará', self::SG_UF => 'CE', self::NO_REGIAO => self::REGIOES[2]],
                [self::NO_UF => 'Distrito Federal', self::SG_UF => 'DF', self::NO_REGIAO => self::REGIOES[3]],
                [self::NO_UF => 'Espírito Santo', self::SG_UF => 'ES', self::NO_REGIAO => self::REGIOES[4]],
                [self::NO_UF => 'Goiás', self::SG_UF => 'GO', self::NO_REGIAO => self::REGIOES[3]],
                [self::NO_UF => 'Maranhão', self::SG_UF => 'MA', self::NO_REGIAO => self::REGIOES[2]],
                [self::NO_UF => 'Mato Grosso', self::SG_UF => 'MT', self::NO_REGIAO => self::REGIOES[3]],
                [self::NO_UF => 'Mato Grosso do Sul', self::SG_UF => 'MS', self::NO_REGIAO => self::REGIOES[3]],
                [self::NO_UF => 'Minas Gerais', self::SG_UF => 'MG', self::NO_REGIAO => self::REGIOES[4]],
                [self::NO_UF => 'Pará', self::SG_UF => 'PA', self::NO_REGIAO => self::REGIOES[1]],
                [self::NO_UF => 'Paraíba', self::SG_UF => 'PB', self::NO_REGIAO => self::REGIOES[2]],
                [self::NO_UF => 'Paraná', self::SG_UF => 'PR', self::NO_REGIAO => self::REGIOES[5]],
                [self::NO_UF => 'Pernambuco', self::SG_UF => 'PE', self::NO_REGIAO => self::REGIOES[2]],
                [self::NO_UF => 'Piauí', self::SG_UF => 'PI', self::NO_REGIAO => self::REGIOES[2]],
                [self::NO_UF => 'Rio de Janeiro', self::SG_UF => 'RJ', self::NO_REGIAO => self::REGIOES[4]],
                [self::NO_UF => 'Rio Grande do Norte', self::SG_UF => 'RN', self::NO_REGIAO => self::REGIOES[2]],
                [self::NO_UF => 'Rio Grande do Sul', self::SG_UF => 'RS', self::NO_REGIAO => self::REGIOES[5]],
                [self::NO_UF => 'Rondônia', self::SG_UF => 'RO', self::NO_REGIAO => self::REGIOES[1]],
                [self::NO_UF => 'Roraima', self::SG_UF => 'RR', self::NO_REGIAO => self::REGIOES[1]],
                [self::NO_UF => 'Santa Catarina', self::SG_UF => 'SC', self::NO_REGIAO => self::REGIOES[5]],
                [self::NO_UF => 'São Paulo', self::SG_UF => 'SP', self::NO_REGIAO => self::REGIOES[4]],
                [self::NO_UF => 'Sergipe', self::SG_UF => 'SE', self::NO_REGIAO => self::REGIOES[2]],
                [self::NO_UF => 'Tocantins', self::SG_UF => 'TO', self::NO_REGIAO => self::REGIOES[3]]
            ]);
            return;
        }

        \DB::table(self::TB_UF)->insert([
            [self::NO_UF => 'Acre', self::SG_UF => 'AC'],
            [self::NO_UF => 'Alagoas', self::SG_UF => 'AL'],
            [self::NO_UF => 'Amapá', self::SG_UF => 'AP'],
            [self::NO_UF => 'Amazonas', self::SG_UF => 'AM'],
            [self::NO_UF => 'Bahia', self::SG_UF => 'BA'],
            [self::NO_UF => 'Ceará', self::SG_UF => 'CE'],
            [self::NO_UF => 'Distrito Federal', self::SG_UF => 'DF'],
            [self::NO_UF => 'Espírito Santo', self::SG_UF => 'ES'],
            [self::NO_UF => 'Goiás', self::SG_UF => 'GO'],
            [self::NO_UF => 'Maranhão', self::SG_UF => 'MA'],
            [self::NO_UF => 'Mato Grosso', self::SG_UF => 'MT'],
            [self::NO_UF => 'Mato Grosso do Sul', self::SG_UF => 'MS'],
            [self::NO_UF => 'Minas Gerais', self::SG_UF => 'MG'],
            [self::NO_UF => 'Pará', self::SG_UF => 'PA'],
            [self::NO_UF => 'Paraíba', self::SG_UF => 'PB'],
            [self::NO_UF => 'Paraná', self::SG_UF => 'PR'],
            [self::NO_UF => 'Pernambuco', self::SG_UF => 'PE'],
            [self::NO_UF => 'Piauí', self::SG_UF => 'PI'],
            [self::NO_UF => 'Rio de Janeiro', self::SG_UF => 'RJ'],
            [self::NO_UF => 'Rio Grande do Norte', self::SG_UF => 'RN'],
            [self::NO_UF => 'Rio Grande do Sul', self::SG_UF => 'RS'],
            [self::NO_UF => 'Rondônia', self::SG_UF => 'RO'],
            [self::NO_UF => 'Roraima', self::SG_UF => 'RR'],
            [self::NO_UF => 'Santa Catarina', self::SG_UF => 'SC'],
            [self::NO_UF => 'São Paulo', self::SG_UF => 'SP'],
            [self::NO_UF => 'Sergipe', self::SG_UF => 'SE'],
            [self::NO_UF => 'Tocantins', self::SG_UF => 'TO']
        ]);
    }
}