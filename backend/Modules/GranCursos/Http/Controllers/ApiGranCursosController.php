<?php

namespace Modules\GranCursos\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\GranCursos\Entities\Banca;
use Modules\GranCursos\Entities\Orgao;
use Modules\GranCursos\Services\GranCursosService;
use Modules\GranCursos\Transformers\AssuntoResource;
use Modules\GranCursos\Transformers\BancaResource;
use Modules\GranCursos\Transformers\OrgaoResource;

class ApiGranCursosController extends Controller
{
    /**
     * @var GranCursosService
     */
    private $service;

    /**
     * ApiGranCursosController constructor.
     * @param GranCursosService $service
     */
    public function __construct(GranCursosService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function apiAssuntos(Request $request)
    {
        return AssuntoResource::collection($this->service->obterAssuntos());
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function apiBancas()
    {
        return BancaResource::collection(Banca::all());
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function apiOrgaos()
    {
        return OrgaoResource::collection(Orgao::all());
    }
}
