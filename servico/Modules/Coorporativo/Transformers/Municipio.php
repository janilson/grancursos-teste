<?php

namespace Modules\Coorporativo\Transformers;

use Illuminate\Http\Resources\Json\Resource;

/**
 * Class Municipio
 * @package Modules\Coorporativo\Transformers
 */
class Municipio extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
