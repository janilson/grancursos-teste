<?php

namespace Modules\Adesao\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Class RepresentantesPdfMiddleware
 * @package Modules\Adesao\Http\Middleware
 */
class RepresentantesPdfMiddleware
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
            $lista = [];
            foreach ($response->getData()->data as $data) {
                $lista[] = [
                    'no_servidor' => $data->no_servidor,
                    'nu_cpf' =>  $data->nu_cpf,
                    'sg_uf' =>  $data->sg_uf,
                    'no_municipio' =>  $data->no_municipio,
                    'nu_telefone' =>  $data->nu_telefone,
                    'ds_email' =>  $data->ds_email
                ];
            }

            return \PDF::loadView(
                'adesao::representantes-lista',
                ['representantes' => $lista])
                ->setPaper('a4', 'landscape')
                ->setOptions([
                    'header-html' => \View::make('adesao::representantes-header-maiscidadao')->render(),
                    'footer-html' => \View::make('adesao::footer-maiscidadao')->render(),
                ])
                ->download('representantes.pdf');
        }

        return $next($request);
    }
}
