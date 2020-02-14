<?php


namespace Modules\Coorporativo\Repositories;


use Modules\Coorporativo\Entities\Prefeito;

/**
 * Class PrefeitoRepository
 * @package Modules\Coorporativo\Repositories
 */
class PrefeitoRepository implements PrefeitoRepositoryInterface
{
    /**
     * @param int $co_ibge
     * @return Prefeito
     */
    public function obterPrefeitoPorCodigoIbge(int $co_ibge): Prefeito
    {
        $dadosPrefeito = \DB::connection('suas')
            ->table('TB_DIRIGENTE')
            ->select(
                'TB_CIDADE.CO_UF',
                'TB_CIDADE.CO_IBGE_DV as CO_MUNICIPIO_IBGE',
                'TB_CIDADE.NO_CIDADE',
                'TB_DIRIGENTE.NO_DIRIGENTE',
                'RL_ENTIDADE_DIRIGENTE.DT_INICIO_MANDATO',
                'RL_ENTIDADE_DIRIGENTE.DT_FIM_MANDATO'
            )
            ->join(
                'RL_ENTIDADE_DIRIGENTE',
                'TB_DIRIGENTE.CO_SEQ_DIRIGENTE',
                'RL_ENTIDADE_DIRIGENTE.CO_DIRIGENTE'
            )->join(
                'TB_ENTIDADE',
                'RL_ENTIDADE_DIRIGENTE.CO_ENTIDADE',
                'TB_ENTIDADE.CO_SEQ_ENTIDADE'
            )->join(
                'TB_CIDADE',
                'TB_ENTIDADE.CO_CIDADE',
                'TB_CIDADE.CO_SEQ_CIDADE'
            )->where([
                ['RL_ENTIDADE_DIRIGENTE.CO_CARGO', '=', 60],
                ['TB_CIDADE.CO_IBGE_DV', '=', $co_ibge],
                ['RL_ENTIDADE_DIRIGENTE.DT_FIM_MANDATO', '>', date('Y-m-d')]
            ])->first() ?: [];

        return new Prefeito((array)$dadosPrefeito);
    }
}