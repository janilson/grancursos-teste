<?php

namespace Modules\Autenticacao\Exceptions;

use App\Exceptions\BadRequestException;

/**
 * Class CpfNaoLocalizadoException
 * @package Modules\Autenticacao\Exceptions
 */
class CpfNaoLocalizadoException extends BadRequestException
{
    /**
     * CpfNaoLocalizadoException constructor.
     * @param string $message
     * @param int $code
     */
    public function __construct(string $message = 'O CPF informado não foi localizado dentre as adesões realizadas',
                                int $code = 0)
    {
        parent::__construct($message, $code);
    }
}