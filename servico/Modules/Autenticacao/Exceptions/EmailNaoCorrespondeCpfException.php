<?php

namespace Modules\Autenticacao\Exceptions;

use App\Exceptions\BadRequestException;

/**
 * Class EmailNaoCorrespondeCpfException
 * @package Modules\Autenticacao\Exceptions
 */
class EmailNaoCorrespondeCpfException extends BadRequestException
{
    /**
     * EmailNaoCorrespondeCpfException constructor.
     * @param string $message
     * @param int $code
     */
    public function __construct(string $message = 'O e-mail informado não corresponde ao CPF informado', int $code = 0)
    {
        parent::__construct($message, $code);
    }
}