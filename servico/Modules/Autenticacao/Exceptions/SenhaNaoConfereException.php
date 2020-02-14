<?php

namespace Modules\Autenticacao\Exceptions;

use App\Exceptions\BadRequestException;

/**
 * Class SenhaNaoConfereException
 * @package Modules\Autenticacao\Exceptions
 */
class SenhaNaoConfereException extends BadRequestException
{
    /**
     * SenhaNaoConfereException constructor.
     * @param string $message
     * @param int $code
     */
    public function __construct(string $message = 'A senha informada não correspondente ao CPF informado',
                                int $code = 0)
    {
        parent::__construct($message, $code);
    }
}