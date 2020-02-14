<?php

namespace Modules\Inscricao\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Adesao\Entities\Adesao;
use Modules\Adesao\Transformers\AdesaoResource;
use Modules\Autenticacao\Service\UsuarioService;
use Modules\Inscricao\Entities\Grupo;
use Modules\Inscricao\Entities\InscricaoEnvio;
use Modules\Inscricao\Services\InscricaoService;

/**
 * Class InscricaoController
 * @package Modules\Inscricao\Http\Controllers
 */
class InscricaoController extends Controller
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
     * InscricaoController constructor.
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
    public function update(Adesao $adesao, Grupo $grupo, Request $request)
    {
        $respostas = $request->all();
        $date = new \DateTime();

        $usuario = $this
            ->usuarioService
            ->getUsuarioLogado();

        $success = $this
            ->inscricaoService
            ->atualizarItensPorGrupo($adesao, $grupo, $respostas, $usuario, $date);

        return response()->json($success, $success['code']);
    }

    /**
     * @param Adesao $adesao
     * @return AdesaoResource
     * @throws \Exception
     */
    public function store(Adesao $adesao)
    {
        $data = new \DateTime();

        $usuario = $this
            ->usuarioService
            ->getUsuarioLogado();

        $adesao = $this
            ->inscricaoService
            ->iniciarInscricao($adesao, $data, $usuario);

        return new AdesaoResource($adesao);
    }

    /**
     * @param int $co_adesao
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function getPdf(int $co_adesao)
    {

        $inscricao = InscricaoEnvio::ultimoEnvio($co_adesao);

        $headers = [
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename=' . $inscricao->getFileName(),
            'Expires' => '0',
            'Pragma' => 'public'

        ];
        return response()->download(
            $inscricao->ds_caminho_arquivo,
            $inscricao->getFileName(),
            $headers
        );
    }

    public function resumo(Adesao $co_adesao)
    {
        return $this->inscricaoService
            ->gerarPdf($co_adesao, new \DateTime())
            ->stream('adesao.pdf');
    }
}
