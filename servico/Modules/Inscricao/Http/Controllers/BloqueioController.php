<?php

namespace Modules\Inscricao\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Inscricao\Entities\BloqueioInscricao;
use Modules\Inscricao\Transformers\BloqueioResource;

/**
 * Class BloqueioController
 * @package Modules\Inscricao\Http\Controllers
 */
class BloqueioController extends Controller
{
    /**
     * @var Guard
     */
    private $guard;

    /**
     * BloqueioController constructor.
     * @param Guard $guard
     */
    public function __construct(Guard $guard)
    {
        $this->guard = $guard;
    }

    /**
     * @param Request $request
     * @return BloqueioResource
     */
    public function store(Request $request)
    {
        $bloqueio = BloqueioInscricao::firstOrCreate([
            'co_adesao' => $request->get('co_adesao'),
            'co_usuario' => $this->guard->user()->co_usuario,
            'st_bloqueio' => 'B'
        ]);

        return new BloqueioResource($bloqueio);
    }

    /**
     * @param BloqueioInscricao $bloqueio
     * @return BloqueioResource
     */
    public function show(BloqueioInscricao $bloqueio)
    {
        return new BloqueioResource($bloqueio);
    }

    /**
     * @param Request $request
     * @param BloqueioInscricao $bloqueio
     * @return BloqueioResource
     */
    public function update(Request $request, BloqueioInscricao $bloqueio)
    {
        $bloqueio->dh_bloqueio = date('Y-m-d H:i:s');
        $bloqueio->save();

        return new BloqueioResource($bloqueio);
    }

    /**
     * @param BloqueioInscricao $bloqueio
     * @return BloqueioResource
     */
    public function destroy(BloqueioInscricao $bloqueio)
    {
        $bloqueio->st_bloqueio = 'D';
        $bloqueio->save();

        return new BloqueioResource($bloqueio);
    }
}
