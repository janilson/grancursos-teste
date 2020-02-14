<?php


namespace Modules\Adesao\Http\Controllers;


use App\Http\Controllers\Controller;
use Modules\Adesao\Entities\Servidor;
use Modules\Adesao\Filters\ServidorFilter;
use Modules\Adesao\Http\Middleware\RepresentantesCsvMiddleware;
use Modules\Adesao\Http\Middleware\RepresentantesPdfMiddleware;
use Modules\Adesao\Http\Middleware\RepresentantesXlsMiddleware;
use Modules\Adesao\Transformers\ServidorResource;

class ServidorController extends Controller
{
    public function __construct()
    {
        $this->middleware(RepresentantesCsvMiddleware::class, ['only' => ['index']]);
        $this->middleware(RepresentantesXlsMiddleware::class, ['only' => ['index']]);
        $this->middleware(RepresentantesPdfMiddleware::class, ['only' => ['index']]);
    }

    public function index()
    {
        $servidores = Servidor::filtered(app(ServidorFilter::class));

        $isJson = in_array('application/json', explode(',', request()->header('Accept'))) ;

        if (!$isJson) {
            return ServidorResource::collection($servidores->get());
        }

        $sortBy = \request()->order_by ? \request()->order_by : 'co_adesao_servidor';
        $order = \request()->sort_desc == 'true' ? 'desc' : 'asc';
        $rowPerPage = \request()->per_page ? \request()->per_page : 10;

        $result = $servidores
            ->orderBy($sortBy, $order)
            ->paginate($rowPerPage);

        return ServidorResource::collection($result);
    }
}