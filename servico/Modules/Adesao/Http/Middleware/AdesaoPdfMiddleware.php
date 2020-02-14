<?php

namespace Modules\Adesao\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Modules\Adesao\Entities\Adesao;
use Modules\Adesao\Filters\AdesaoFilter;

/**
 * Class AdesaoPdfMiddleware
 * @package Modules\Adesao\Http\Middleware
 */
class AdesaoPdfMiddleware
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
            $adesoes = Adesao::filtered(app(AdesaoFilter::class))->get()->toArray();

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
                    'no_municipio' => $data['no_municipio'],
                    'no_uf' => $data['no_uf'],
                    'no_regiao' => $data['no_regiao'],
                    'tp_grupo_municipio' => $fn($data['tp_grupo_municipio']),
                    'nu_populacao' => $data['nu_populacao'],
                ];
            }

            return \PDF::loadView(
                'adesao::adesoes-lista',
                [
                    'adesoes' => $lista
                ])
                ->setPaper('a4', 'landscape')
                ->setOptions([
                    'header-html' => \View::make('adesao::adesao-header-maiscidadao')->render(),
                    'footer-html' => \View::make('adesao::footer-maiscidadao')->render(),
                ])
                ->download('adesoes.pdf');
        }

        return $next($request);
    }
}
