<?php

namespace Modules\Adesao\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Excel;
use Modules\Adesao\Exports\InscritosExport;

/**
 * Class InscritosCsvMiddleware
 * @package Modules\Adesao\Http\Middleware
 */
class InscritosCsvMiddleware
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
        if ($request->header('Accept') == 'text/csv') {
            return (new InscritosExport())->download('inscritos.csv', Excel::CSV, ['Content-Type' => 'text/csv']);
        }

        return $next($request);
    }
}
