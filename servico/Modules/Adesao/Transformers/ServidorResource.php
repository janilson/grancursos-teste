<?php

namespace Modules\Adesao\Transformers;

use Illuminate\Http\Resources\Json\Resource;

/**
 * Class ServidorResource
 * @package Modules\Adesao\Transformers
 */
class ServidorResource extends Resource
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
            'co_adesao_servidor' => (integer)$this->co_adesao_servidor,
            'co_adesao' => (integer)$this->co_adesao,
            'nu_cpf' => preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $this->nu_cpf),
            'no_servidor' => $this->no_servidor,
            'ds_email' => $this->ds_email,
            'nu_telefone' => preg_replace('/([0-9]{2})([0-9]{4,5})([0-9]{4})/', '(${1}) ${2}-${3}', $this->nu_telefone),
            'no_funcao' => $this->no_funcao,
            'no_lotacao' => $this->no_lotacao,
            'st_coordenador' => $this->st_coordenador,
            'no_municipio' => $this->no_municipio,
            'sg_uf' => $this->sg_uf
        ];
    }
}
