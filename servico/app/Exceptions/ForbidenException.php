<?php


namespace App\Exceptions;


use Illuminate\Http\Response;

class ForbidenException extends AbstractHttpJsonException
{
    public function __construct(string $message = 'Acesso negado', int $code = 0)
    {
        parent::__construct($message, $code, Response::HTTP_FORBIDDEN, 'Forbiden');
    }
}
