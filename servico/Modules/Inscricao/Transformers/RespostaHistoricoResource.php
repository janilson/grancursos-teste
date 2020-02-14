<?php

namespace Modules\Inscricao\Transformers;

use Illuminate\Http\Resources\Json\Resource;

/**
 * Class RespostaHistoricoResource
 * @package Modules\Inscricao\Transformers
 */
class RespostaHistoricoResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'co_resposta' => (int)$this->co_resposta,
            'dh_resposta' => \DateTime::createFromFormat('Y-m-d H:i:s', $this->dh_resposta)->format('d/m/Y H:i:s'),
            'co_usuario' => (int)$this->usuario->co_usuario,
            'nu_cpf' => preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $this->usuario->nu_cpf),
            'no_usuario' => $this->usuario->no_usuario,
            'co_grupo' => (int)$this->grupo()->co_grupo,
            'ds_grupo' => $this->grupo()->ds_grupo,
            'ds_item' => $this->resposta->item->ds_formulario_item_inscricao,
            'ds_item_pai' => $this->resposta->item->descricaoPai(),
            'co_formulario_resposta' => (int)$this->co_formulario_resposta,
            'st_resposta_antiga' => (bool)$this->st_resposta_antiga,
            'st_resposta_atual' => (bool)$this->st_resposta_atual,
        ];
    }
}
