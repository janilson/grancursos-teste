<?php

namespace Modules\Inscricao\Exceptions;

use App\Exceptions\BadRequestException;

/**
 * Class ErroAoSalvarRespostasGrupoInvalidoException
 * @package Modules\Inscricao\Exceptions
 */
class ErroAoSalvarRespostasGrupoInvalidoException extends BadRequestException
{
    protected $code = 0;
    protected $message = "Erro ao salvar as respostas, não são os itens de '%message%'.";

    /**
     * ErroAoSalvarRespostasGrupoInvalidoException constructor.
     * @param $no_grupo
     */
    public function __construct($no_grupo)
    {
        parent::__construct(str_replace('%message%', $no_grupo, $this->message), $this->code);
    }
}