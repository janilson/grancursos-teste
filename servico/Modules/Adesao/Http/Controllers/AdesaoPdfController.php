<?php

namespace Modules\Adesao\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Adesao\Entities\Adesao;
use Modules\Adesao\Services\AdesaoService;
use Modules\Adesao\Transformers\AdesaoResource;

/**
 * Class AdesaoPdfController
 * @package Modules\Adesao\Http\Controllers
 */
class AdesaoPdfController extends Controller
{
    /**
     * @var AdesaoService
     */
    private $adesaoService;

    /**
     * AdesaoPdfController constructor.
     * @param AdesaoService $adesaoService
     */
    public function __construct(AdesaoService $adesaoService)
    {
        $this->adesaoService = $adesaoService;
    }

    /**
     * @param Adesao $adesao
     * @return \Illuminate\Http\Response
     */
    public function gerarPdf(Adesao $adesao)
    {
        return $this->adesaoService->baixarPdf($adesao);
    }
}