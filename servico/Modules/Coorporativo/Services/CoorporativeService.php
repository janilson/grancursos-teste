<?php


namespace Modules\Coorporativo\Services;


use Modules\Coorporativo\Entities\Prefeito;
use Modules\Coorporativo\Entities\Uf;
use Modules\Coorporativo\Repositories\PrefeitoRepository;

/**
 * Class CoorporativeService
 * @package Modules\Coorporativo\Services
 */
class CoorporativeService
{
    /**
     * @var PrefeitoRepository
     */
    private $prefeitoRepository;

    /**
     * CoorporativeService constructor.
     * @param PrefeitoRepository $prefeitoRepository
     */
    public function __construct(PrefeitoRepository $prefeitoRepository)
    {
        $this->prefeitoRepository = $prefeitoRepository;
    }

    /**
     * @param int $co_ibge
     * @return Prefeito
     */
    public function obterPrefeitoPorIbge(int $co_ibge): Prefeito
    {
        return $this->prefeitoRepository->obterPrefeitoPorCodigoIbge($co_ibge);
    }

    /**
     * @return mixed
     */
    public function obterUnidadesFederativas()
    {
        return Uf::orderBy('no_uf')->get();
    }
}