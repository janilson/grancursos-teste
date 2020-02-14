<?php

namespace Modules\Inscricao\Exceptions;

use App\Exceptions\BadRequestException;

/**
 * Class ErroAoSalvarInscricaoEnvioException
 * @package Modules\Inscricao\Exceptions
 */
class ErroAoSalvarInscricaoEnvioException extends BadRequestException
{
    protected $code = 0;
    protected $message = "Erro ao enviar a inscrição do '%message%'.";

    /**
     * ErroAoSalvarInscricaoEnvioException constructor.
     * @param string $no_municipio
     */
    public function __construct(string $no_municipio)
    {
        parent::__construct(str_replace('%message%', $no_municipio, $this->message), $this->code);
    }
}