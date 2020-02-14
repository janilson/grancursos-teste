<?php

namespace Modules\Inscricao\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Inscricao\Entities\Arquivo;
use Modules\Inscricao\Services\InscricaoService;

/**
 * Class ArquivoController
 * @package Modules\Inscricao\Http\Controllers
 */
class ArquivoController extends Controller
{
    /**
     * @var InscricaoService
     */
    private $inscricaoService;

    /**
     * InscricaoController constructor.
     * @param InscricaoService $inscricaoService
     */
    public function __construct(InscricaoService $inscricaoService)
    {
        $this->inscricaoService = $inscricaoService;
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show(Arquivo $arquivo)
    {
        return response()->download($arquivo->ds_caminho_arquivo, $arquivo->no_arquivo,
            [
                'Cache-Control' => 'no-cache private',
                'Content-Description' => 'File Transfer',
                'Content-Type' => $arquivo->ds_content_type,
                'Content-length' => strlen($arquivo->ds_caminho_arquivo),
                'Content-Disposition' => 'attachment; filename=' . $arquivo->no_arquivo,
                'Content-Transfer-Encoding' => 'binary'
            ]);
    }
}
