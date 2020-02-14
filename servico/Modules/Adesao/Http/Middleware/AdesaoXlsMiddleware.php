<?php

namespace Modules\Adesao\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Excel;
use Modules\Adesao\Exports\AdesaoExport;

/**
 * Class AdesaoXlsMiddleware
 * @package Modules\Adesao\Http\Middleware
 */
class AdesaoXlsMiddleware
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
            return (new AdesaoExport())->download('adesao.xls', Excel::XLS, ['Content-Type' => 'application/xls']);
        }

        return $next($request);
    }
}
