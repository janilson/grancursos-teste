<?php

namespace Modules\Adesao\Exceptions;

use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * Class JaExisteCpfCadastradoEmAdesaoException
 * @package Modules\Adesao\Exceptions
 */
class JaExisteCpfCadastradoEmAdesaoException extends HttpResponseException
{
    /**
     * JaExisteCpfCadastradoEmAdesaoException constructor.
     * @param array $listaCpf
     */
    public function __construct(array $listaCpf)
    {
        $response = response()->json([
            "Os seguintes CPF's já estão cadastrados:\n" . implode(", ", array_column($listaCpf, 'nu_cpf'))
        ], 400);
        parent::__construct($response);
    }
}