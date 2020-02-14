<?php

namespace Modules\Adesao\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use Modules\Adesao\Exports\InscritosExport;

/**
 * Class InscritosXlsMiddleware
 * @package Modules\Adesao\Http\Middleware
 */
class InscritosXlsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->header('Accept') == 'application/xls') {
            return (new InscritosExport())->download('inscricao.xls', Excel::XLS, ['Content-Type' => 'application/xls']);
        }

        return $next($request);
    }
}
