<?php

namespace Modules\GranCursos\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Expression;
use Thalfm\LaravelEloquentFilter\Filters\SimpleQueryFilter;

/**
 * Class QuestaoFilter
 * @package Modules\GranCursos\Filters
 */
class AssuntoFilter extends SimpleQueryFilter
{
//    protected $simpleFilters = ['id_assunto'];

    /**
     * @param $query
     * @return Builder
     */
    public function apply($query)
    {
        $query->select(
            [
                'tb_assunto.id_assunto',
                'tb_assunto.no_assunto',
                'tb_assunto.id_assunto_pai',
            ])
            ->distinct()
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
                'tb_questao.id_orgao');

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
