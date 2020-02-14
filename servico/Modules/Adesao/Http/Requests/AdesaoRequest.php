<?php

namespace Modules\Adesao\Http\Requests;

use App\Http\Requests\CustomFormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

/**
 * Class AdesaoRequest
 * @package Modules\Adesao\Http\Requests
 */
class AdesaoRequest extends CustomFormRequest
{
    const SERVIDOR_2_CPF = 'servidores.2.nu_cpf';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "co_municipio" => [
                self::REQUIRED,
                self::EXISTS . 'tb_municipio,co_municipio',
            ],
            "no_prefeito" => [
                self::REQUIRED,
                self::STRING,
                self::MAX . 200
            ],

            "servidores" => [
                self::REQUIRED,
                self::ARRAY
            ],
            "servidores.*.nu_cpf" => [
                self::REQUIRED,
                self::CPF
            ],
            "servidores.*.no_servidor" => [
                self::REQUIRED,
                self::MAX . 200
            ],
            "servidores.*.ds_email" => [
                self::REQUIRED,
                self::EMAIL,
                self::MAX . 100
            ],
            "servidores.*.nu_telefone" => [
                self::REQUIRED,
                self::TELEFONE_COM_DDD
            ],
            "servidores.*.no_funcao" => [
                self::REQUIRED,
                self::STRING,
                self::MAX . 100
            ],
            "servidores.*.no_lotacao" => [
                self::REQUIRED,
                self::STRING,
                self::MAX . 100
            ],
            "servidores.*.st_coordenador" => [
                self::REQUIRED,
                self::STRING,
                self::SIZE . 1,
                self::IN . 's,n,S,N'
            ],

            "servidores.0.nu_cpf" => [
                self::CPF,
                self::DIFFERENT . 'servidores.1.nu_cpf',
                self::DIFFERENT . self::SERVIDOR_2_CPF,

            ],

            "servidores.1.nu_cpf" => [
                self::CPF,
                self::DIFFERENT . self::SERVIDOR_2_CPF,
            ],

            self::SERVIDOR_2_CPF => [
                self::CPF,
            ],
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'co_municipio.required' => 'Selecione um município',
            'co_municipio.exists' => 'O município selecionado é inválido',
            'no_prefeito.required' => 'O campo nome do prefeito é obrigatório',

            "servidores.0.nu_cpf.required" => 'Informe o CPF do 1º Servidor',
            "servidores.0.nu_cpf." . self::CPF => 'Informe um CPF válido para o 1º Servidor',
            "servidores.0.no_servidor.required" => 'Informe o nome do 1º Servidor',
            "servidores.0.no_servidor.max" => 'Limite de caracteres excedido do nome do 1º Servidor',
            "servidores.0.ds_email.required" => 'Informe o e-mail do 1º Servidor',
            "servidores.0.ds_email.email" => 'Informe um e-mail válido para o 1º Servidor',
            "servidores.0.ds_email.max" => 'Limite de caracteres excedido do e-mail do 1º Servidor',
            "servidores.0.nu_telefone.required" => 'Informe o telefone do 1º Servidor',
            "servidores.0.nu_telefone." . self::TELEFONE_COM_DDD => 'Informe um telefone válido para o 1º Servidor',
            "servidores.0.no_funcao.required" => 'Informe o cargo/função do 1º Servidor',
            "servidores.0.no_funcao.max" => 'Limite de caracteres excedido da função do 1º Servidor',
            "servidores.0.no_lotacao.required" => 'Informe a lotação do 1º Servidor',
            "servidores.0.no_lotacao.max" => 'Limite de caracteres excedido da lotação do 1º Servidor',
            "servidores.0.nu_cpf.different" => 'Não é permido inserir o mesmo CPF para servidores diferentes',

            "servidores.1.nu_cpf.required" => 'Informe o CPF do 2º Servidor',
            "servidores.1.nu_cpf." . self::CPF => 'Informe um CPF válido para o 2º Servidor',
            "servidores.1.no_servidor.max" => 'Limite de caracteres excedido do nome do 2º Servidor',
            "servidores.1.no_servidor.required" => 'Informe o nome do 2º Servidor',
            "servidores.1.ds_email.required" => 'Informe o e-mail do 2º Servidor',
            "servidores.1.ds_email.max" => 'Limite de caracteres excedido do e-mail do 2º Servidor',
            "servidores.1.ds_email.email" => 'Informe um e-mail válido para o 2º Servidor',
            "servidores.1.nu_telefone.required" => 'Informe o telefone do 2º Servidor',
            "servidores.1.nu_telefone." . self::TELEFONE_COM_DDD => 'Informe um telefone válido para o 2º Servidor',
            "servidores.1.no_funcao.max" => 'Limite de caracteres excedido da função do 2º Servidor',
            "servidores.1.no_funcao.required" => 'Informe o cargo/função do 2º Servidor',
            "servidores.1.no_lotacao.max" => 'Limite de caracteres excedido da lotação do 2º Servidor',
            "servidores.1.no_lotacao.required" => 'Informe a lotação do 2º Servidor',
            "servidores.1.nu_cpf.different" => 'Não é permido inserir o mesmo CPF para servidores diferentes',

            "servidores.2.nu_cpf.required" => 'Informe o CPF do 3º Servidor',
            "servidores.2.nu_cpf." . self::CPF => 'Informe um CPF válido para o 3º Servidor',
            "servidores.2.no_servidor.max" => 'Limite de caracteres excedido do nome do 3º Servidor',
            "servidores.2.no_servidor.required" => 'Informe o nome do 3º Servidor',
            "servidores.2.ds_email.required" => 'Informe o e-mail do 3º Servidor',
            "servidores.2.ds_email." . self::EMAIL => 'Informe um e-mail válido para o 3º Servidor',
            "servidores.2.ds_email.max" => 'Limite de caracteres excedido do e-mail do 3º Servidor',
            "servidores.2.nu_telefone.required" => 'Informe o telefone do 3º Servidor',
            "servidores.2.nu_telefone." . self::TELEFONE_COM_DDD => 'Informe um telefone válido para o 3º Servidor',
            "servidores.2.no_funcao.max" => 'Limite de caracteres excedido da função do 3º Servidor',
            "servidores.2.no_funcao.required" => 'Informe o cargo/função do 3º Servidor',
            "servidores.2.no_lotacao.max" => 'Limite de caracteres excedido da lotação do 3º Servidor',
            "servidores.2.no_lotacao.required" => 'Informe a lotação do 3º Servidor',

            'required' => 'O campo ":attribute" é obrigatório!',

            'max' => 'Limite de caracteres excedido',
        ];
    }

    /**
     * @return array
     */
    public function getListaCpfServidores(): array
    {
        $listaCpf = array_column($this->get('servidores', []), 'nu_cpf');

        $cpfSemFormato = function ($value) {
            return preg_replace('/[^0-9]/', '', $value);
        };

        return array_map($cpfSemFormato, $listaCpf);
    }

    /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            \response()->json(
                $validator->errors()->first(),
                Response::HTTP_BAD_REQUEST
            )
        );
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
