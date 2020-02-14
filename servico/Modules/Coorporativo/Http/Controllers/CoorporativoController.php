<?php

namespace Modules\Coorporativo\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Coorporativo\Entities\Uf;
use Modules\Coorporativo\Services\CoorporativeService;

/**
 * Class CoorporativoController
 * @package Modules\Coorporativo\Http\Controllers
 */
class CoorporativoController extends Controller
{
    /**
     * @var CoorporativeService
     */
    private $coorporativeService;

    /**
     * CoorporativoController constructor.
     * @param CoorporativeService $coorporativeService
     */
    public function __construct(CoorporativeService $coorporativeService)
    {
        $this->coorporativeService = $coorporativeService;
    }

    /**
     * @param int $co_ibge
     * @return \Modules\Coorporativo\Entities\Prefeito
     */
    public function obterPrefeitoPorIbge(int $co_ibge)
    {
        return $this->coorporativeService->obterPrefeitoPorIbge($co_ibge);
    }

    /**
     * @return mixed
     */
    public function obterUnidadesFederativas()
    {
        return $this->coorporativeService->obterUnidadesFederativas();
    }

    /**
     * @param Uf $uf
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function obterMunicipiosDaUnidadeFederativa(Uf $uf)
    {
        return $uf->municipios()->orderBy('no_municipio')->get();
    }
}
