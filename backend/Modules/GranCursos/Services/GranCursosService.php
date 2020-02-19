<?php

namespace Modules\GranCursos\Services;

use Modules\GranCursos\Entities\Assunto;
use Modules\GranCursos\Filters\AssuntoFilter;

/**
 * Class GranCursosService
 * @package Modules\GranCursos\Services
 */
class GranCursosService
{
    /**
     * @return mixed
     */
    public function obterAssuntos()
    {
        $questoes = Assunto::filtered(\App::make(AssuntoFilter::class))->get();

        return $questoes;
    }
}
