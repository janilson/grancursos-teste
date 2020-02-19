<?php

namespace Modules\GranCursos\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Expression;
use Illuminate\Support\Facades\DB;
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
//        $query->select(
//            [
//                'tb_assunto.id_assunto',
//                'tb_assunto.no_assunto',
//                'tb_assunto.id_assunto_pai',
//            ])
//            ->distinct()
//            ->leftJoin('tb_questao',
//                'tb_questao.id_assunto',
//                '=',
//                'tb_assunto.id_assunto')
//            ->leftJoin('tb_banca',
//                'tb_banca.id_banca',
//                '=',
//                'tb_questao.id_banca')
//            ->leftJoin('tb_orgao',
//                'tb_orgao.id_orgao',
//                '=',
//                'tb_questao.id_orgao');

        $sql = "WITH RECURSIVE recursive_assunto AS (
                     SELECT a.id_assunto,
                            a.no_assunto,
                            a.id_assunto_pai,
                            1 AS nu_nivel,
                            CONCAT(a.id_assunto, '') as ds_order
                       FROM tb_assunto a

                      WHERE a.id_assunto_pai IS NULL

                      UNION ALL

                     SELECT a.id_assunto,
                            a.no_assunto,
                            a.id_assunto_pai,
                            ra.nu_nivel + 1 AS nu_nivel,
                            CONCAT(ra.ds_order, '-', a.id_assunto)  as ds_order
                       FROM tb_assunto a
                       JOIN recursive_assunto ra
                         ON ra.id_assunto = a.id_assunto_pai
                )

                SELECT ra.id_assunto,
                       ra.no_assunto,
                       ra.id_assunto_pai,
                       ra.nu_nivel,
                       ra.ds_order,
                       COUNT(DISTINCT tq.id_questao) AS nu_total_questoes
                  FROM recursive_assunto ra
                  LEFT JOIN tb_questao tq
                    ON tq.id_assunto = ra.id_assunto
                  LEFT JOIN tb_banca tb
                    ON tb.id_banca = tq.id_banca
                  LEFT JOIN tb_orgao tor
                    ON tor.id_orgao = tq.id_orgao
                 GROUP BY ra.id_assunto,
                          ra.no_assunto,
                          ra.id_assunto_pai,
                          ra.nu_nivel,
                          ra.ds_order
                 ORDER BY ds_order";

        $query = DB::select(new Expression($sql));

        $this->query = $query;
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


        $this->query->where('ra.id_assunto', '=', $value);
    }

    /**
     * @param null $value
     */
    protected function applyIdBanca($value = null)
    {
        if (0 == (int)$value) {
            return;
        }

        dd($this->query);

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
