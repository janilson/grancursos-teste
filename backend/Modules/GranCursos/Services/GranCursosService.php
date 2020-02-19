<?php

namespace Modules\GranCursos\Services;

use Modules\GranCursos\Entities\Assunto;
use Modules\GranCursos\Filters\AssuntoFilter;
use Nwidart\Modules\Collection;

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
        $questoes = Assunto::filtered(\App::make(AssuntoFilter::class));

        $itens = [];
        $principal = null;
        $filho = null;
        $neto = null;

        foreach ($questoes as $questao) {
            if ($questao->nu_nivel == 1) {
                $principal = $questao->id_assunto;
                $itens[$principal] = (array)$questao;
                continue;
            }

            if ($questao->nu_nivel == 2) {
                $filho = $questao->id_assunto;
                $itens[$principal]['filhos'][$filho] = (array)$questao;
                continue;
            }

            if ($questao->nu_nivel == 3) {
                $itens[$principal]['filhos'][$filho]['netos'][$questao->id_assunto] = (array)$questao;
                continue;
            }
        }

        $itens = collect($itens);
        return $itens;
    }
}
