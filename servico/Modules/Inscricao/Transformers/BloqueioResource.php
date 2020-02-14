<?php

namespace Modules\Inscricao\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class BloqueioResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'co_bloqueio_inscricao' => $this->co_bloqueio_inscricao,
            'co_adesao' => $this->co_adesao,
            'co_usuario' => $this->co_usuario,
            'st_bloqueio' => $this->st_bloqueio,
            'dh_bloqueio' => $this->dh_bloqueio,
            'usuario' => $this->usuario
        ];
    }
}
