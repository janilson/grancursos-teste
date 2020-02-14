<?php

namespace Modules\Administrativo\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Class HistoricosPdfMiddleware
 * @package Modules\Inscricao\Http\Middleware
 */
class ClassificacaoPdfMiddleware
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
                        'no_municipio' => $data->no_municipio,
                        'sg_uf' => $data->sg_uf,
                        'ds_grupo_municipio' => $data->ds_grupo_municipio,
                        'nu_pontuacao_total' => $data->nu_pontuacao_total,
                        'nu_classificacao' => $data->nu_classificacao,
                    ];
                });

            return \PDF::loadView(
                'administrativo::classificacao-lista',
                ['classificacoes' => $data])
                ->setPaper('a4', 'landscape')
                ->setOptions([
                    'header-html' => \View::make('administrativo::classificacao-header-maiscidadao')->render(),
                    'footer-html' => \View::make('adesao::footer-maiscidadao')->render(),
                ])
                ->download('classificacao.pdf');
        }

        return $next($request);
    }
}
