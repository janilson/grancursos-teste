<?php

namespace Modules\Adesao\Exceptions;

use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * Class JaExisteTermoAdesaoParaMunicipioException
 * @package Modules\Adesao\Exceptions
 */
class JaExisteTermoAdesaoParaMunicipioException extends HttpResponseException
{
    /**
     * JaExisteTermoAdesaoParaMunicipioException constructor.
     */
    public function __construct()
    {
        $response = response()->json([
            "Já existe um termo de adesão cadastrado para este município",
        ], 400);
        parent::__construct($response);
    }
}