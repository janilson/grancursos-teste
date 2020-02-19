<?php

namespace Modules\GranCursos\Services;

use Modules\GranCursos\Entities\Questao;
use Modules\GranCursos\Filters\QuestaoFilter;

/**
 * Class GranCursosService
 * @package Modules\GranCursos\Services
 */
class GranCursosService
{
    /**
     * @return mixed
     */
    public function obterQuestoes()
    {
        $questoes = Questao::filtered(\App::make(QuestaoFilter::class))->get();

        return $questoes;
    }
}
