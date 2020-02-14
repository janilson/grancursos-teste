<?php

namespace Modules\Inscricao\Transformers;

use Illuminate\Http\Resources\Json\Resource;

/**
 * Class GrupoResource
 * @package Modules\Inscricao\Transformers
 */
class GrupoResource extends Resource
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
            'co_grupo' => $this->co_grupo,
            'ds_grupo' => $this->ds_grupo,
            'nu_pontuacao_total' => $this->nu_pontuacao_total,
            'itens' => $this->when($request->get('not'), [], ItemResource::collection($this->itens))
        ];
    }
}
