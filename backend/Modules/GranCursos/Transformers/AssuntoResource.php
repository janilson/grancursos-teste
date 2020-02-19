<?php

namespace Modules\GranCursos\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class AssuntoResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
//        return parent::toArray($request);

        $return = [
            'id_assunto' => $this->id_assunto,
            'no_assunto' => $this->no_assunto,
        ];

        $filhos = $this->filhos;

        if ($filhos) {
            $return['filhos'] = AssuntoResource::collection($filhos);
        }

        return $return;
    }
}
