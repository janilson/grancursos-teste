<?php


namespace App\Exceptions;


use Illuminate\Http\Exceptions\HttpResponseException;

abstract class AbstractHttpJsonException extends HttpResponseException
{
    public function __construct(string $message = '', int $code = 0, $statusCode = 0, string $type = 'Undefined')
    {
        $response = response()->json([
            'code' => $code,
            'message' => $message,
            'type' => $type
        ], $statusCode);
        parent::__construct($response);
    }
}