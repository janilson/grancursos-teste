<?php

namespace Modules\Adesao\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Excel;
use Modules\Adesao\Exports\AdesaoExport;
use Modules\Adesao\Exports\RepresentantesExport;

/**
 * Class RepresentantesXlsMiddleware
 * @package Modules\Adesao\Http\Middleware
 */
class RepresentantesXlsMiddleware
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

        if ($request->header('Accept') == 'application/xls') {
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
            return (new RepresentantesExport($lista))->download('representantes.xls', Excel::XLS, ['Content-Type' => 'text/csv']);
        }

        return $next($request);
    }
}
