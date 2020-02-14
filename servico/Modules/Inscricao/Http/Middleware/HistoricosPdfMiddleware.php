<?php

namespace Modules\Inscricao\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Class HistoricosPdfMiddleware
 * @package Modules\Inscricao\Http\Middleware
 */
class HistoricosPdfMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($request->header('Accept') == 'application/pdf') {
            $data = (new Collection($response->getData()->data))
                ->map(function ($data) {
                    return [
                        'dh_resposta' => $data->dh_resposta,
                        'nu_cpf' => $data->nu_cpf,
                        'no_usuario' => $data->no_usuario,
                        'ds_grupo' => $data->ds_grupo,
                        'ds_item' => $data->ds_item,
                        'st_resposta_antiga' => $data->st_resposta_antiga ? "Marcado" : "Desmarcado",
                        'st_resposta_atual' => $data->st_resposta_atual ? "Marcado" : "Desmarcado",
                    ];
                });

            return \PDF::loadView(
                'inscricao::historicos-lista',
                ['historicos' => $data])
                ->setPaper('a4', 'landscape')
                ->setOptions([
                    'header-html' => \View::make('inscricao::historicos-header-maiscidadao')->render(),
                    'footer-html' => \View::make('adesao::footer-maiscidadao')->render(),
                ])
                ->download('historicos.pdf');
        }

        return $next($request);
    }
}
