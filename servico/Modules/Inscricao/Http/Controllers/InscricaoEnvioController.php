<?php

namespace Modules\Inscricao\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Adesao\Entities\Adesao;
use Modules\Autenticacao\Service\UsuarioService;
use Modules\Inscricao\Services\InscricaoService;

/**
 * Class InscricaoEnvioController
 * @package Modules\Inscricao\Http\Controllers
 */
class InscricaoEnvioController extends Controller
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
     * InscricaoEnvioController constructor.
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
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(Adesao $adesao)
    {
        $date = new \DateTime();

        $usuario = $this
            ->usuarioService
            ->getUsuarioLogado();

        $success = $this
            ->inscricaoService
            ->enviarInscricao($adesao, $date, $usuario);

        return response()->json($success, $success['code']);
    }
}
