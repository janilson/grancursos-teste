<?php

namespace Modules\Adesao\Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdesaoControllerTest extends TestCase
{
    use DatabaseTransactions;

    const NU_CPF = 'nu_cpf';
    const NO_SERVIDOR = 'no_servidor';
    const NO_EMAIL = 'no_email';
    const NU_TELEFONE = 'nu_telefone';
    const NO_FUNCAO = 'no_funcao';
    const NO_LOTACAO = 'no_lotacao';
    const ST_COORDENADOR = 'st_coordenador';

    const ROUTE = '/api/adesao/';

    /**
     * @test
     * @dataProvider  dadosTermoAdesao
     * @param $dadosTermoAdesao
     */
    public function cadastrar_termo_adesao($dadosTermoAdesao)
    {
        $response = $this->post(self::ROUTE, $dadosTermoAdesao);
        $response->assertStatus(201);
    }


    /**
     * @test
     */
    public function cadastrar_termo_adesao_dados_invalidos()
    {
        $response = $this->post(self::ROUTE, []);
        $response->assertStatus(400);
    }

    /**
     * @test
     * @dataProvider dadosTermoAdesaoCpfInvalidos
     */
    public function cadastrar_termo_adesao_cpf_invalidos($dadosTermoAdesaoCpfInvalidos)
    {
        $response = $this->post(self::ROUTE, $dadosTermoAdesaoCpfInvalidos);
        $response->assertStatus(400);
        $this->assertStringContainsString('Informe um CPF v\u00e1lido para o 1\u00ba Servidor', $response->getContent());
    }

    public function dadosTermoAdesao()
    {
        return [
            [
                [
                    "no_prefeito" => "teste",
                    "no_uf" => "sp",
                    "no_municipio" => "brasilia",
                    "co_ibge" => 111111,
                    "servidores" => [
                        [
                            self::NU_CPF => "71636585086",
                            self::NO_SERVIDOR => "nome contato 1",
                            self::NO_EMAIL => "thales.martins@teceirizado.cidadania.gov.br",
                            self::NU_TELEFONE => "(61)99999-9999",
                            self::NO_FUNCAO => "teste função 1",
                            self::NO_LOTACAO => "Guará",
                            self::ST_COORDENADOR => "S"
                        ],
                        [
                            self::NU_CPF => "54856462040",
                            self::NO_SERVIDOR => "nome contato",
                            self::NO_EMAIL => "thales.martins@gmail.com.br",
                            self::NU_TELEFONE => "(61)66666-6666",
                            self::NO_FUNCAO => "teste função 2",
                            self::NO_LOTACAO => "Sudoeste",
                            self::ST_COORDENADOR => "S"
                        ],
                        [
                            self::NU_CPF => "01422442012",
                            self::NO_SERVIDOR => "nome contato",
                            self::NO_EMAIL => "thales.martins@outlook.com.br",
                            self::NU_TELEFONE => "(61)33333-3333",
                            self::NO_FUNCAO => "teste função 3",
                            self::NO_LOTACAO => "Esplanada",
                            self::ST_COORDENADOR => "S"
                        ]
                    ]
                ]
            ]
        ];
    }

    public function dadosTermoAdesaoCpfInvalidos()
    {
        return [
            [
                [
                    "no_prefeito" => "teste",
                    "no_uf" => "sp",
                    "no_municipio" => "brasilia",
                    "co_ibge" => 290020,
                    "servidores" => [
                        [
                            self::NU_CPF => "00000000001",
                        ],
                        [
                            self::NU_CPF => "22222222222",
                        ],
                        [
                            self::NU_CPF => "11111111111",
                        ]
                    ]
                ]
            ]
        ];
    }
}
