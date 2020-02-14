<?php

namespace Modules\Inscricao\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Adesao\Entities\Adesao;
use Modules\Inscricao\Http\Middleware\HistoricosCsvMiddleware;
use Modules\Inscricao\Http\Middleware\HistoricosPdfMiddleware;
use Modules\Inscricao\Http\Middleware\HistoricosXlsMiddleware;
use Modules\Inscricao\Services\InscricaoService;
use Modules\Inscricao\Transformers\RespostaHistoricoResource;

/**
 * Class HistoricoController
 * @package Modules\Inscricao\Http\Controllers
 */
class HistoricoController extends Controller
{
    /**
     * @var InscricaoService
     */
    private $inscricaoService;

    /**
     * HistoricoController constructor.
     * @param InscricaoService $inscricaoService
     */
    public function __construct(InscricaoService $inscricaoService)
    {
        $this->middleware(HistoricosCsvMiddleware::class, ['only' => ['index']]);
        $this->middleware(HistoricosPdfMiddleware::class, ['only' => ['index']]);
        $this->middleware(HistoricosXlsMiddleware::class, ['only' => ['index']]);

        $this->inscricaoService = $inscricaoService;
    }

    /**
     * @param Adesao $adesao
     * @return AnonymousResourceCollection
     */
    public function index(Adesao $adesao)
    {
        $itens = $this->inscricaoService->obterRespostasHistoricos($adesao);

        $isJson = in_array('application/json', explode(',', request()->header('Accept'))) ;

        if (!$isJson) {
            return RespostaHistoricoResource::collection($itens->get());
        }

        $sortBy = \request()->order_by ? \request()->order_by : 'co_adesao';
        $order = \request()->sort_desc == 'true' ? 'desc' : 'asc';
        $rowPerPage = \request()->per_page ? \request()->per_page : 10;

        $result = $itens
            ->orderBy($sortBy, $order)
            ->paginate($rowPerPage);

        return RespostaHistoricoResource::collection($result);
    }
}
