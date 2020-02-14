<?php


namespace App\Exceptions;


use Illuminate\Http\Response;

class BadRequestException extends AbstractHttpJsonException
{
    public function __construct(string $message = 'Bad Request', int $code = 0)
    {
        parent::__construct($message, $code, Response::HTTP_BAD_REQUEST, 'Bad Request');
    }
}
