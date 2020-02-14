<?php


namespace Modules\Inscricao\Exceptions;


use App\Exceptions\BadRequestException;

/**
 * Class AdesaoJaPossuiInscricaoException
 * @package Modules\Inscricao\Exceptions
 */
class AdesaoJaPossuiInscricaoException extends BadRequestException
{
    /**
     * AdesaoJaPossuiInscricaoException constructor.
     * @param string $message
     * @param int $code
     */
    public function __construct(string $message = 'Já existe uma inscrição para esta adesão', int $code = 0)
    {
        parent::__construct($message, $code);
    }
}