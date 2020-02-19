<?php

namespace Modules\GranCursos\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Expression;
use Thalfm\LaravelEloquentFilter\Filters\SimpleQueryFilter;

/**
 * Class QuestaoFilter
 * @package Modules\GranCursos\Filters
 */
class QuestaoFilter extends SimpleQueryFilter
{
    protected $simpleFilters = ['id_questao', 'id_assunto', 'id_banca', 'id_orgao'];

    /**
     * @param $query
     * @return Builder
     */
    public function apply($query)
    {
        return parent::apply($query);
    }
}
