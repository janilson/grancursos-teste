<?php

namespace Modules\Adesao\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Adesao\Entities\Adesao;
use Modules\Adesao\Filters\AdesaoFilter;
use Modules\Adesao\Http\Middleware\AdesaoCsvMiddleware;
use Modules\Adesao\Http\Middleware\AdesaoPdfMiddleware;
use Modules\Adesao\Http\Middleware\AdesaoXlsMiddleware;
use Modules\Adesao\Http\Middleware\InscritosCsvMiddleware;
use Modules\Adesao\Http\Middleware\InscritosPdfMiddleware;
use Modules\Adesao\Http\Middleware\InscritosXlsMiddleware;
use Modules\Adesao\Http\Requests\AdesaoRequest;
use Modules\Adesao\Services\AdesaoService;
use Modules\Adesao\Transformers\AdesaoResource;

/**
 * Class AdesaoController
 * @package Modules\Adesao\Http\Controllers
 */
class AdesaoController extends Controller
{
    /**
     * @var AdesaoService
     */
    private $adesaoService;

    /**
     * AdesaoController constructor.
     * @param Request $request
     * @param AdesaoService $adesaoService
     */
    public function __construct(Request $request, AdesaoService $adesaoService)
    {
        $this->middleware('auth:api', ['only' => ['index']]);

        if ($request->get('com_inscricao')) {
            $this->middleware(InscritosXlsMiddleware::class, ['only' => ['index']]);
            $this->middleware(InscritosCsvMiddleware::class, ['only' => ['index']]);
            $this->middleware(InscritosPdfMiddleware::class, ['only' => ['index']]);
        } else if (!$request->get('usuario_logado')) {
            $this->middleware('check.profile:I', ['only' => ['index', 'store']]);
            $this->middleware(AdesaoCsvMiddleware::class, ['only' => ['index']]);
            $this->middleware(AdesaoXlsMiddleware::class, ['only' => ['index']]);
            $this->middleware(AdesaoPdfMiddleware::class, ['only' => ['index']]);
        } else {
            $this->middleware(AdesaoCsvMiddleware::class, ['only' => ['index']]);
            $this->middleware(AdesaoXlsMiddleware::class, ['only' => ['index']]);
            $this->middleware(AdesaoPdfMiddleware::class, ['only' => ['index']]);
        }

        $this->adesaoService = $adesaoService;
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $adesoes = Adesao::filtered(app(AdesaoFilter::class));

        $isJson = in_array('application/json', explode(',', request()->header('Accept')));

        if ($request->get('all') || !$isJson) {
            return AdesaoResource::collection($adesoes->get());
        }

        $sortBy = \request()->order_by ? \request()->order_by : 'tb_adesao.co_adesao';
        $order = \request()->sort_desc == 'true' ? 'desc' : 'asc';
        $rowPerPage = \request()->per_page ? \request()->per_page : 10;

        $result = $adesoes
            ->orderBy($sortBy, $order)
            ->paginate($rowPerPage);

        return AdesaoResource::collection($result);
    }

    /**
     * @param AdesaoRequest $request
     * @return AdesaoResource
     * @throws \Exception
     */
    public function update(Adesao $adesao, Request $request)
    {
        $update = $request->except(['co_adesao']);
        $adesao->update($update);

        return new AdesaoResource($adesao);
    }

    /**
     * @param AdesaoRequest $request
     * @return AdesaoResource
     * @throws \Exception
     */
    public function store(AdesaoRequest $request)
    {
        $adesao = $this->adesaoService->criar($request);
        return new AdesaoResource($adesao);
    }

    /**
     * @param Adesao $adesao
     * @return AdesaoResource
     */
    public function show(Adesao $adesao)
    {
        return new AdesaoResource($adesao);
    }
}
