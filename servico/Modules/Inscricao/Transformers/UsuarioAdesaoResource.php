<?php

namespace Modules\Inscricao\Transformers;

use Illuminate\Http\Resources\Json\Resource;

/**
 * Class UsuarioAdesaoResource
 * @package Modules\Inscricao\Transformers
 */
class UsuarioAdesaoResource extends Resource
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
            "co_adesao" => (int)$this->co_adesao,
            "no_municipio" => $this->municipio->no_municipio . ' - ' . $this->municipio->uf->sg_uf,
        ];
    }
}
