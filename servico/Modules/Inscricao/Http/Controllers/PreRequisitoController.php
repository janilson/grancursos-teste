<?php

namespace Modules\Inscricao\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Adesao\Entities\Adesao;
use Modules\Autenticacao\Service\UsuarioService;
use Modules\Inscricao\Entities\Grupo;
use Modules\Inscricao\Services\InscricaoService;

/**
 * Class PreInscricaoController
 * @package Modules\Inscricao\Http\Controllers
 */
class PreRequisitoController extends Controller
{
    /**
     * @var InscricaoService
     */
    private $inscricaoService;
    /**
     * @var UsuarioService
     */
    private $usuarioService;

    /**
     * PreInscricaoController constructor.
     * @param InscricaoService $inscricaoService
     * @param UsuarioService $usuarioService
     */
    public function __construct(InscricaoService $inscricaoService, UsuarioService $usuarioService)
    {
        $this->inscricaoService = $inscricaoService;
        $this->usuarioService = $usuarioService;
    }

    /**
     * @param Adesao $adesao
     * @param Grupo $grupo
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(Adesao $adesao, Grupo $grupo, Request $request)
    {
        $request->request->remove('co_adesao');
        $request->request->remove('co_grupo');

        $respostas = [];
        foreach ($request->request->all() as $resposta) {
            $respostas[] = [
                'co_formulario_resposta'=> (int)$resposta['co_formulario_resposta'],
                'st_resposta'=> true,
            ];
        }

        $date = new \DateTime();

        $usuario = $this
            ->usuarioService
            ->getUsuarioLogado();

        $file = $request->hasFile('ds_arquivo') ? $request->file('ds_arquivo') : null;

        $success = $this
            ->inscricaoService
            ->salvarPreRequisitos($adesao, $grupo, (array)$respostas, $usuario, $date, $file);

        return response()->json($success, $success['code']);
    }
}
