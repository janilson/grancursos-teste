<?php

namespace Modules\Administrativo\Exceptions;

use App\Exceptions\BadRequestException;

/**
 * Class AdesaoNaoExisteException
 * @package Modules\Administrativo\Exceptions
 */
class AdesaoInvalidaException extends BadRequestException
{
    protected $code = 0;
    protected $message = "Não foi localizado município classificado!";

    /**
     * AdesaoInvalidaException constructor.
     */
    public function __construct()
    {
        parent::__construct($this->message, $this->code);
    }
}