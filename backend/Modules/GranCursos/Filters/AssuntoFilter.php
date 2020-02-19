<?php

namespace Modules\GranCursos\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Expression;
use Modules\GranCursos\Entities\Assunto;
use Thalfm\LaravelEloquentFilter\Filters\SimpleQueryFilter;

/**
 * Class QuestaoFilter
 * @package Modules\GranCursos\Filters
 */
class AssuntoFilter extends SimpleQueryFilter
{
    /**
     * @param $query
     * @return Builder
     */
    public function apply($query)
    {
        $baseQuery = Assunto::select(
            [
                'tb_assunto.id_assunto',
                'tb_assunto.no_assunto',
                'tb_assunto.id_assunto_pai',
                new Expression('1 AS nu_nivel'),
                new Expression("CONCAT(tb_assunto.id_assunto, '') as ds_order")
            ])
            ->whereNull('id_assunto_pai')
            ->unionAll(
                Assunto::select(
                    [
                        'tb_assunto.id_assunto',
                        'tb_assunto.no_assunto',
                        'tb_assunto.id_assunto_pai',
                        new Expression('ra.nu_nivel + 1 AS nu_nivel'),
                        new Expression("CONCAT(ra.ds_order, '-', tb_assunto.id_assunto) as ds_order")
                    ])
                    ->join('ra', 'ra.id_assunto', '=', 'tb_assunto.id_assunto_pai')
            );

        $query->select(
            [
                'ra.id_assunto',
                'ra.no_assunto',
                'ra.id_assunto_pai',
                'ra.nu_nivel',
                'ra.ds_order',
                'ra.ds_order',
                new Expression('GROUP_CONCAT(DISTINCT tb_banca.id_banca) AS id_banca_array'),
                new Expression('GROUP_CONCAT(DISTINCT tb_orgao.id_orgao) AS id_orgao_array'),
                new Expression('GROUP_CONCAT(DISTINCT tb_questao.id_questao) AS id_questao_array'),
                new Expression('COUNT(tb_questao.id_questao) AS nu_total_questoes')
            ])
            ->from('ra')
            ->withRecursiveExpression('ra', $baseQuery)
            ->join('tb_assunto',
                'tb_assunto.id_assunto',
                '=',
                'ra.id_assunto')
            ->leftJoin('tb_questao',
                'tb_questao.id_assunto',
                '=',
                'tb_assunto.id_assunto')
            ->leftJoin('tb_banca',
                'tb_banca.id_banca',
                '=',
                'tb_questao.id_banca')
            ->leftJoin('tb_orgao',
                'tb_orgao.id_orgao',
                '=',
                'tb_questao.id_orgao')
            ->groupBy('ra.id_assunto')
            ->groupBy('ra.no_assunto')
            ->groupBy('ra.id_assunto_pai')
            ->groupBy('ra.nu_nivel')
            ->groupBy('ra.ds_order')
            ->orderBy('ra.ds_order');

        return parent::apply($query);
    }

    /**
     * @param null $value
     */
    protected function applyIdAssunto($value = null)
    {
        if (0 == (int)$value) {
            return;
        }


        $this->query->where('tb_assunto.id_assunto', '=', $value);
    }

    /**
     * @param null $value
     */
    protected function applyIdBanca($value = null)
    {
        if (0 == (int)$value) {
            return;
        }

        $this->query->where('tb_banca.id_banca', '=', $value);
    }

    /**
     * @param null $value
     */
    protected function applyIdOrgao($value = null)
    {
        if (0 == (int)$value) {
            return;
        }

        $this->query->where('tb_orgao.id_orgao', '=', $value);
    }

    /**
     * @param null $value
     */
    protected function applyIdQuestao($value = null)
    {
        if (0 == (int)$value) {
            return;
        }

        $this->query->where('tb_questao.id_questao', '=', $value);
    }
}
