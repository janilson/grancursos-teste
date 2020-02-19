<?php

namespace Modules\GranCursos\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\GranCursos\Services\GranCursosService;

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
    public function index()
    {
        $itens = $this->service->obterQuestoes();

        dd($itens);
    }
}
