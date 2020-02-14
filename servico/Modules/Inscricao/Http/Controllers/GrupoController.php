<?php

namespace Modules\Inscricao\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Inscricao\Entities\Grupo;
use Modules\Inscricao\Transformers\GrupoResource;

/**
 * Class GrupoController
 * @package Modules\Inscricao\Http\Controllers
 */
class GrupoController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $grupo = Grupo::all();
        return GrupoResource::collection($grupo);
    }
}