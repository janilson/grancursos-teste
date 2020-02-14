<?php

namespace Modules\Autenticacao\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class RecuperarSenhaRequest
 * @package Modules\Autenticacao\Http\Requests
 */
class RecuperarSenhaRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nu_cpf' => 'required',
            'ds_email' => 'required'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
