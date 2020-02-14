<?php

namespace Modules\Administrativo\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Excel;
use Modules\Administrativo\Exports\ClassificacaoExport;

/**
 * Class HistoricosCsvMiddleware
 * @package Modules\Inscricao\Http\Middleware
 */
class ClassificacaoCsvMiddleware
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
            $data = (new Collection($response->getData()->data))
                ->map(function ($data) {
                    return [
                        $data->no_municipio,
                        $data->sg_uf,
                        $data->ds_grupo_municipio,
                        $data->nu_pontuacao_total,
                        $data->nu_classificacao,
                    ];
                });
            return (new ClassificacaoExport($data))->download('classificacao.csv', Excel::CSV, ['Content-Type' => 'text/csv']);
        }

        return $next($request);
    }
}
