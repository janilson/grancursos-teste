<?php

namespace Modules\Adesao\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Excel;
use Modules\Adesao\Exports\RepresentantesExport;

/**
 * Class RepresentantesCsvMiddleware
 * @package Modules\Adesao\Http\Middleware
 */
class RepresentantesCsvMiddleware
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

        if ($request->header('Accept') == 'text/csv') {
            $lista = [];
            foreach ($response->getData()->data as $data) {
                $lista[] = [
                    $data->no_servidor,
                    $data->nu_cpf,
                    $data->sg_uf,
                    $data->no_municipio,
                    $data->nu_telefone,
                    $data->ds_email
                ];
            }

            return (new RepresentantesExport($lista))->download('representantes.csv', Excel::CSV, ['Content-Type' => 'text/csv']);
        }

        return $next($request);
    }
}
