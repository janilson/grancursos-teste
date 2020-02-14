<?php

namespace Modules\Administrativo\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Expression;
use Thalfm\LaravelEloquentFilter\Filters\SimpleQueryFilter;

/**
 * Class ClassificacaoFilter
 * @package Modules\Administrativo\Filters
 */
class ClassificacaoFilter extends SimpleQueryFilter
{
    const CO_ADESAO = 'co_adesao';
    const CO_ARQUIVO = 'co_arquivo';
    const CO_MUNICIPIO = 'co_municipio';
    const CO_UF = 'co_uf';
    const CO_USUARIO = 'co_usuario';

    const TB_ADESAO = 'tb_adesao';
    const TB_ARQUIVO = 'tb_arquivo';
    const TB_MUNICIPIO = 'tb_municipio';
    const TB_INSCRICAO_ENVIO = 'tb_inscricao_envio';
    const TB_UF = 'tb_uf';
    const TB_USUARIO = 'tb_usuario';

    protected $simpleFilters = ['tp_grupo_municipio'];

    /**
     * @param Builder $query
     * @return Builder
     */
    public function apply($query)
    {
        $sqlJoin = "SELECT a.CO_ADESAO, 
                           MAX(CO_INSCRICAO_ENVIO) AS CO_INSCRICAO_ENVIO       
                      FROM DB_MAISCIDADAO.TB_INSCRICAO_ENVIO a 
                     GROUP BY a.CO_ADESAO";

        $sql = 'RANK() OVER (PARTITION BY ' . self::TB_MUNICIPIO . '.tp_grupo_municipio 
                                 ORDER BY ' . self::TB_INSCRICAO_ENVIO . '.nu_pontuacao_atual DESC) AS nu_classificacao';

        $subQuery2 = \DB::query()->raw($sql);

        $sql = 'ROW_NUMBER() OVER (PARTITION BY ' . self::TB_MUNICIPIO . '.tp_grupo_municipio 
                                      ORDER BY ' . self::TB_INSCRICAO_ENVIO . '.nu_pontuacao_atual DESC, 
                                               ' . self::TB_MUNICIPIO . '.nu_populacao DESC) AS nu_posicao';

        $subQuery3 = \DB::query()->raw($sql);

        $subQuery = \DB::query()
            ->select([
                self::TB_ADESAO . '.co_adesao',
                self::TB_ADESAO . '.st_adesao_quali',
                self::TB_ADESAO . '.st_pcf_quali',
                self::TB_ADESAO . '.st_progredir_quali',
                self::TB_ADESAO . '.st_paa_quali',
                self::TB_ADESAO . '.st_senapredi_quali',
                self::TB_ARQUIVO . '.co_arquivo',
                self::TB_MUNICIPIO . '.co_municipio',
                self::TB_MUNICIPIO . '.no_municipio',
                self::TB_MUNICIPIO . '.tp_grupo_municipio',
                self::TB_MUNICIPIO . '.nu_populacao',
                self::TB_UF . '.sg_uf',
                self::TB_INSCRICAO_ENVIO . '.nu_pontuacao_atual AS nu_pontuacao_total',
                self::TB_INSCRICAO_ENVIO . '.ds_envio',
                self::TB_INSCRICAO_ENVIO . '.dh_envio',
                self::TB_USUARIO . '.nu_cpf AS nu_cpf_envio',
                self::TB_USUARIO . '.no_usuario AS no_usuario_envio',
                self::TB_USUARIO . '.ds_email AS ds_email_envio',
                new Expression($subQuery2),
                new Expression($subQuery3)
            ])
            ->from(self::TB_ADESAO)
            ->join(self::TB_MUNICIPIO,
                self::TB_MUNICIPIO . '.' . self::CO_MUNICIPIO,
                '=',
                self::TB_ADESAO . '.' . self::CO_MUNICIPIO)
            ->join(self::TB_UF,
                self::TB_UF . '.' . self::CO_UF,
                '=',
                self::TB_MUNICIPIO . '.' . self::CO_UF)
            ->joinSubOracle($sqlJoin,
                'MAX_INSCRICAO_ENVIO',
                new Expression('MAX_INSCRICAO_ENVIO.co_adesao'),
                '=',
                self::TB_ADESAO . '.' . self::CO_ADESAO)
            ->join(self::TB_INSCRICAO_ENVIO,
                self::TB_INSCRICAO_ENVIO . '.co_inscricao_envio',
                '=',
                new Expression('MAX_INSCRICAO_ENVIO.co_inscricao_envio'))
            ->join(self::TB_USUARIO,
                self::TB_USUARIO . '.' . self::CO_USUARIO,
                '=',
                self::TB_INSCRICAO_ENVIO  . '.co_usuario_envio')
            ->leftJoin(self::TB_ARQUIVO,
                self::TB_ARQUIVO . '.' . self::CO_ARQUIVO,
                '=',
                self::TB_ADESAO . '.' . self::CO_ARQUIVO);

        $query->fromSub($subQuery, 'classificacao')
            ->orderBy('tp_grupo_municipio')
            ->orderBy('nu_posicao')
            ->where('nu_classificacao', '<=', 9);

        return parent::apply($query);
    }

    /**
     * @param $value
     * @throws \Exception
     */
    protected function applyNuPosicao($value = null)
    {
        if (0 == (int)$value) {
            return;
        }

        $operator = $value <= 3 ? "=" : ">=";

        $this->query->where('nu_posicao', $operator, $value);
    }

    /**
     * @param $value
     * @throws \Exception
     */
    protected function applyNuClassificacao($value = null)
    {
        if (0 == (int)$value) {
            return;
        }

        $operator = $value <= 3 ? "=" : ">=";

        $this->query->where('nu_classificacao', $operator, $value);
    }
}