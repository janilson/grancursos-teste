<?php

namespace Modules\Inscricao\Transformers;

use Illuminate\Http\Resources\Json\Resource;

/**
 * Class PerguntaResource
 * @package Modules\Inscricao\Transformers
 */
class PerguntaResource extends Resource
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
            'co_pergunta' => $this->co_formulario_item_inscricao,
            'ds_pergunta' => $this->ds_formulario_item_inscricao,
        ];
    }
}
