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
        $questoes = Assunto::filtered(\App::make(AssuntoFilter::class))->get();

        $itens = [];
        $principal = null;
        $filho = null;
        $neto = null;

        foreach ($questoes as $questao) {
            if ($questao->nu_nivel == 1) {
                $principal = $questao['id_assunto'];

                $itens[$principal] = $this->_generateArrayQuestao($questao);
                continue;
            }

            if ($questao->nu_nivel == 2) {
                $filho = $questao['id_assunto'];
                $itens[$principal]['filhos'][$filho] = $this->_generateArrayQuestao($questao);
                continue;
            }

            if ($questao->nu_nivel == 3) {
                $neto = $questao['id_assunto'];
                $itens[$principal]['filhos'][$filho]['netos'][$neto] = $this->_generateArrayQuestao($questao);
                continue;
            }
        }

        $itens = collect($itens);

        return $itens;
    }

    /**
     * @param Assunto $assunto
     * @return array|null
     */
    private function _generateArrayQuestao(Assunto $assunto): ?array
    {

        return $assunto ?
            [
                'id_assunto' => $assunto['id_assunto'],
                'no_assunto' => $assunto['no_assunto'],
                'id_assunto_pai' => $assunto['id_assunto_pai'],
                'nu_nivel' => $assunto['nu_nivel'],
                'ds_order' => $assunto['ds_order'],
                'nu_total_questoes' => $assunto['nu_total_questoes'],
            ] : null;
    }
}
