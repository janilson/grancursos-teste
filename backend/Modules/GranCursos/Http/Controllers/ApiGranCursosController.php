<?php

namespace Modules\GranCursos\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\GranCursos\Services\GranCursosService;
use Modules\GranCursos\Transformers\AssuntoResource;

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
        dd("aquie");
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function apiOrgaos()
    {
        dd("aquie");
    }
}
