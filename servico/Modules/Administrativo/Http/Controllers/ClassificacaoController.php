<?php

namespace Modules\Administrativo\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Adesao\Entities\Adesao;
use Modules\Administrativo\Http\Middleware\ClassificacaoCsvMiddleware;
use Modules\Administrativo\Http\Middleware\ClassificacaoPdfMiddleware;
use Modules\Administrativo\Http\Middleware\ClassificacaoXlsMiddleware;
use Modules\Administrativo\Services\AdministrativoService;
use Modules\Administrativo\Transformers\ClassificacaoResource;
use Modules\Autenticacao\Service\UsuarioService;

/**
 * Class ClassificacaoController
 * @package Modules\Administrativo\Http\Controllers
 */
class ClassificacaoController extends Controller
{
    /**
     * @var AdministrativoService
     */
    private $administrativoService;

    /**
     * @var UsuarioService
     */
    private $usuarioService;

    /**
     * HistoricoController constructor.
     * @param InscricaoService $inscricaoService
     */
    public function __construct(AdministrativoService $administrativoService, UsuarioService $usuarioService)
    {
        $this->middleware(ClassificacaoCsvMiddleware::class, ['only' => ['index']]);
        $this->middleware(ClassificacaoPdfMiddleware::class, ['only' => ['index']]);
        $this->middleware(ClassificacaoXlsMiddleware::class, ['only' => ['index']]);

        $this->administrativoService = $administrativoService;
        $this->usuarioService = $usuarioService;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $itens = $this->administrativoService->obterClassicacoes();

        $isJson = in_array('application/json', explode(',', request()->header('Accept'))) ;

        if (!$isJson) {
            return ClassificacaoResource::collection($itens->get());
        }

        $sortBy = \request()->order_by ? \request()->order_by : 'nu_classificacao';
        $order = \request()->sort_desc == 'true' ? 'desc' : 'asc';
        $rowPerPage = \request()->per_page ? \request()->per_page : 10;

        $result = $itens
            ->orderBy($sortBy, $order)
            ->paginate($rowPerPage);

        return ClassificacaoResource::collection($result);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store()
    {
        $data = new \DateTime();

        $usuario = $this
            ->usuarioService
            ->getUsuarioLogado();

        $success = $this
            ->administrativoService
            ->aprovarClassificados($data, $usuario);

        return response()->json($success, $success['code']);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show(Adesao $adesao)
    {
        $item = $this->administrativoService->obterClassicacaoAdesao($adesao);

        return new ClassificacaoResource($item);
    }
}
