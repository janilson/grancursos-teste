<?php
/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 26/06/19
 * Time: 18:31
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomFormRequest extends FormRequest
{
    const REQUIRED = 'required';
    const MAX = 'max:';
    const EMAIL = 'email:rfc';
    const STRING = 'string';
    const NUMERIC = 'numeric';
    const ARRAY = 'array';
    const SIZE = 'size:';
    const CELULAR_COM_DDD = 'celular_com_ddd';
    const TELEFONE_COM_DDD = 'telefone_com_ddd';
    const CPF = 'cpf';
    const IN = 'in:';
    const DIFFERENT = 'different:';
    const EXISTS = 'exists:';

    public function messages()
    {
        return [
            'required' => 'O campo ":attribute" é obrigatório!'
        ];
    }
}