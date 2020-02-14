<?php

namespace Modules\Inscricao\Transformers;

use Illuminate\Http\Resources\Json\Resource;

/**
 * Class ArquivoResource
 * @package Modules\Inscricao\Transformers
 */
class ArquivoResource extends Resource
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
            'co_arquivo' => $this->co_arquivo,
            'no_arquivo' => $this->no_arquivo,
            'no_extensao' => $this->no_extensao,
            'no_mime_type' => $this->no_mime_type,
        ];
    }
}
