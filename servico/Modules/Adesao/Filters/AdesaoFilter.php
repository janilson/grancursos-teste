<?php

namespace Modules\Adesao\Filters;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\Expression;
use Illuminate\Support\Collection;
use Thalfm\LaravelEloquentFilter\Filters\SimpleQueryFilter;
use Thalfm\LaravelEloquentFilter\Parsers\SimpleQueryParser;

/**
 * Class AdesaoFilter
 * @package Modules\Adesao\Filters
 */
class AdesaoFilter extends SimpleQueryFilter
{
    protected $simpleFilters = [
      'no_regiao',
      'tp_grupo_municipio'
    ];
    /**
     * @var Guard
     */
    private $guard;

    /**
     * AdesaoFilter constructor.
     * @param SimpleQueryParser $parser
     * @param Collection $collection
     * @param Container $app
     */
    public function __construct(SimpleQueryParser $parser, Collection $collection, Container $app)
    {
        $this->guard = $app->get(Guard::class);
        parent::__construct($parser, $collection, $app);
    }

    /**
     * @param $value
     */
    public function applyUsuarioLogado($value)
    {
        if ($value != 'true') {
            return;
        }

        $cpf = $this->guard->user()->getAuthIdentifier();

        $this->query
            ->join('tb_adesao_servidor', function (Builder $join) use ($cpf) {
                $join->on(
                    'tb_adesao.co_adesao',
                    '=',
                    'tb_adesao_servidor.co_adesao'
                )->where(
                    'tb_adesao_servidor.nu_cpf',
                    '=',
                    $cpf
                );
            });
    }

    /**
     * @param $value
     */
    public function applySemInscricao($value)
    {
        if ($value != 'true') {
            return;
        }

        $this->query
            ->leftJoin(
                'tb_formulario_resposta',
                'tb_adesao.co_adesao',
                '=',
                'tb_formulario_resposta.co_adesao'
            )->whereNull('tb_formulario_resposta.co_adesao');
    }

    /**
     * @param $value
     */
    public function applyComInscricao($value)
    {
        if ($value != 'true') {
            return;
        }

        $this->query
            ->whereExists(function (Builder $query) {
                $query->select()
                    ->from('tb_formulario_resposta')
                    ->whereRaw('tb_adesao.co_adesao = tb_formulario_resposta.co_adesao');
            });
    }

    /**
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply($query)
    {
        $sqlJoin = "SELECT ta.CO_ADESAO, COALESCE(SUM(tfii.NU_PONTUACAO), 0) AS nu_pontuacao_total
                      FROM DB_MAISCIDADAO.TB_ADESAO ta
                      LEFT JOIN DB_MAISCIDADAO.TB_FORMULARIO_RESPOSTA tfa
                        ON tfa.CO_ADESAO = ta.CO_ADESAO
                       AND tfa.ST_RESPOSTA = '1'
                      LEFT JOIN DB_MAISCIDADAO.TB_FORMULARIO_ITEM_INSCRICAO tfii
                        ON tfii.CO_FORMULARIO_ITEM_INSCRICAO = tfa.CO_FORMULARIO_ITEM_INSCRICAO
                     GROUP BY ta.CO_ADESAO";

        $query
            ->select(
                'tb_adesao.*',
                'tb_municipio.no_municipio',
                'tb_municipio.nu_populacao',
                'tb_municipio.tp_grupo_municipio',
                'tb_uf.sg_uf',
                'tb_uf.no_uf',
                'tb_uf.no_regiao',
            )
            ->addSelect([
                'nu_pontuacao_total',
                ])
            ->joinSubOracle($sqlJoin,
                'pontuacao',
                new Expression('pontuacao.co_adesao'),
                '=',
                'tb_adesao.co_adesao')
            ->leftJoin(
                'tb_municipio',
                'tb_adesao.co_municipio',
                '=',
                'tb_municipio.co_municipio'
            )
            ->leftJoin(
                'tb_uf',
                'tb_municipio.co_uf',
                '=',
                'tb_uf.co_uf'
            );
        return parent::apply($query);
    }

    /**
     * @param $value
     * @throws \Exception
     */
    protected function applyNuPontuacao($value = null)
    {
        $this->query->where('nu_pontuacao_total', ">", $value);
    }
}