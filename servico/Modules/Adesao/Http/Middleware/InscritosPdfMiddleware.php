<?php

namespace Modules\Adesao\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Modules\Adesao\Entities\Adesao;
use Modules\Adesao\Filters\AdesaoFilter;

/**
 * Class InscritosPdfMiddleware
 * @package Modules\Adesao\Http\Middleware
 */
class InscritosPdfMiddleware
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
        if ($request->header('Accept') == 'application/pdf') {
            $adesoes = Adesao::filtered(app(AdesaoFilter::class))->get();

            $array = [
                1 => 'Grupo I',
                2 => 'Grupo II',
                3 => 'Grupo III',
                4 => 'Grupo IV',
                5 => 'Grupo V',
            ];

            $fn = function ($tipo) use ($array) {
                return $array[$tipo];
            };

            $lista = [];
            foreach ($adesoes as $data) {
                $lista[] = [
                    'no_municipio' => $data->no_municipio,
                    'no_uf' => $data->no_uf,
                    'no_regiao' => $data->no_regiao,
                    'tp_grupo_municipio' => $fn($data->tp_grupo_municipio),
                    'nu_populacao' => $data->nu_populacao,
                    'nu_pontuacao_total' => $data->nu_pontuacao_total
                ];
            }

            return \PDF::loadView(
                'adesao::inscricoes-lista',
                ['inscricoes' => $lista])
                ->setPaper('a4', 'landscape')
                ->setOptions([
                    'header-html' => \View::make('adesao::inscricoes-header-maiscidadao')->render(),
                    'footer-html' => \View::make('adesao::footer-maiscidadao')->render(),
                ])
                ->download('inscricao.pdf');
        }


        return $next($request);
    }
}
