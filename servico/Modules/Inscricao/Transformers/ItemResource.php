<?php

namespace Modules\Inscricao\Transformers;

use Illuminate\Http\Resources\Json\Resource;

/**
 * Class ItemResource
 * @package Modules\Inscricao\Transformers
 */
class ItemResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $co_adesao = $request->get('co_adesao');
        $this->respostaAdesao($co_adesao);
        return [
            'co_formulario_item_inscricao' => $this->co_formulario_item_inscricao,
            'ds_formulario_item_inscricao' => $this->ds_formulario_item_inscricao,
            'nu_pontuacao' => (int)$this->nu_pontuacao,
            'nu_pontuacao' => (int)$this->nu_pontuacao,
            'tp_formulario_item_inscricao' => $this->tp_formulario_item_inscricao,
            'pergunta' => new PerguntaResource($this->pai),
            'co_formulario_resposta' => (int)$this->co_formulario_resposta,
            'st_resposta' => (bool)$this->st_resposta,
        ];
    }
}
