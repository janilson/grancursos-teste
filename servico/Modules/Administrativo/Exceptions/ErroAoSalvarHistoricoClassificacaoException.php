<?php

namespace Modules\Administrativo\Exceptions;

use App\Exceptions\BadRequestException;

/**
 * Class ErroAoSalvarHistoricoClassificacaoException
 * @package Modules\Administrativo\Exceptions
 */
class ErroAoSalvarHistoricoClassificacaoException extends BadRequestException
{
    protected $code = 0;
    protected $message = "Ocorreu erro inesperado, favor tentar novamente mais tarde!";

    /**
     * ErroAoSalvarHistoricoClassificacaoException constructor.
     */
    public function __construct()
    {
        parent::__construct($this->message, $this->code);
    }
}