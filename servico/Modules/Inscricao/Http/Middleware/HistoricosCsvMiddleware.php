<?php

namespace Modules\Inscricao\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Excel;
use Modules\Inscricao\Exports\HistoricosExport;

/**
 * Class HistoricosCsvMiddleware
 * @package Modules\Inscricao\Http\Middleware
 */
class HistoricosCsvMiddleware
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
                        $data->dh_resposta,
                        $data->nu_cpf,
                        $data->no_usuario,
                        $data->ds_grupo,
                        $data->ds_item,
                        $data->st_resposta_antiga ? "Marcado" : "Desmarcado",
                        $data->st_resposta_atual ? "Marcado" : "Desmarcado",
                    ];
                });
            return (new HistoricosExport($data))->download('historicos.csv', Excel::CSV, ['Content-Type' => 'text/csv']);
        }

        return $next($request);
    }
}
