<?php

namespace Modules\Adesao\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use Modules\Adesao\Exports\AdesaoExport;

/**
 * Class AdesaoCsvMiddleware
 * @package Modules\Adesao\Http\Middleware
 */
class AdesaoCsvMiddleware
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
            return (new AdesaoExport())->download('adesao.csv', Excel::CSV, ['Content-Type' => 'text/csv']);
        }

        return $next($request);
    }
}
