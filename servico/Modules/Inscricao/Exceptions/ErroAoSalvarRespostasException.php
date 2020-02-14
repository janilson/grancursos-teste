<?php

namespace Modules\Inscricao\Exceptions;

use App\Exceptions\BadRequestException;

/**
 * Class ErroAoSalvarRespostasException
 * @package Modules\Inscricao\Exceptions
 */
class ErroAoSalvarRespostasException extends BadRequestException
{
    protected $code = 0;
    protected $message = "Erro ao salvar '%message%'.";

    /**
     * ErroAoSalvarRespostasException constructor.
     * @param $no_grupo
     */
    public function __construct($no_grupo)
    {
        parent::__construct(str_replace('%message%', $no_grupo, $this->message), $this->code);
    }
}