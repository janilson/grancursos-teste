<?php

namespace Modules\GranCursos\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class AssuntoResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $return = [
            'id_assunto' => $this['id_assunto'],
            'no_assunto' => $this['no_assunto'],
            'id_assunto_pai' => $this['id_assunto_pai'],
            'nu_total_questoes' => $this['nu_total_questoes'],
        ];

        $filhos = $this['filhos'] ?? [];

        if (count($filhos) > 0) {
            $return['filhos'] = AssuntoResource::collection($filhos);
        }

        $netos = $this['netos'] ?? [];

        if (count($netos) > 0) {
            $return['netos'] = AssuntoResource::collection($netos);
        }

        return $return;
    }
}
