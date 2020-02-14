<?php

namespace Modules\Autenticacao\Http\Requests;

use App\Http\Requests\CustomFormRequest;

/**
 * Class AuthRequest
 * @package Modules\Autenticacao\Http\Requests
 */
class AuthRequest extends CustomFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nu_cpf' => 'required',
            'ds_senha' => 'required'
        ];
    }
}
