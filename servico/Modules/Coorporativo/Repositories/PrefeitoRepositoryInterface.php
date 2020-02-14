<?php


namespace Modules\Coorporativo\Repositories;


use Modules\Coorporativo\Entities\Prefeito;

/**
 * Interface PrefeitoRepositoryInterface
 * @package Modules\Coorporativo\Repositories
 */
interface PrefeitoRepositoryInterface
{
    /**
     * @param int $co_ibge
     * @return Prefeito
     */
    public function obterPrefeitoPorCodigoIbge(int $co_ibge): Prefeito;
}