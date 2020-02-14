<?php


namespace App\Exceptions;


use Illuminate\Http\Response;

class UnauthorizedException extends AbstractHttpJsonException
{
    public function __construct(string $message = 'Usuário não autenticado', int $code = 0)
    {
        parent::__construct($message, $code, Response::HTTP_UNAUTHORIZED, 'Unauthorized');
    }
}
