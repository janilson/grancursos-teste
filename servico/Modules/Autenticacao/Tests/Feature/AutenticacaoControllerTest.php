<?php

namespace Modules\Autenticacao\Tests\Feature;

use Tests\TestCase;

class AutenticacaoControllerTest extends TestCase
{

    const ROUTE = '/api/auth/login';

    const MESSAGE = 'message';

    const SENHA = 'senha';

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
    }

    public function usuarioUmProvider()
    {
        return [
            ['cpf' => '04788897121', self::SENHA => 'mds123']
        ];
    }

    public function usuarioDoisProvider()
    {
        return [
            ['cpf' => '03906633101', self::SENHA => 'mds789']
        ];
    }

    /**
     * @test
     * @dataProvider usuarioUmProvider
     */
    public function usuario_incorreto($usuario)
    {
        $response = $this->json('POST', self::ROUTE, $usuario);

        $response
            ->assertStatus(401)
            ->assertJson([
                self::MESSAGE => "Credenciais do usuário incorretas",
            ]);
    }

    /**
     * @test
     * @dataProvider usuarioDoisProvider
     */

    public function usuario_valido($usuario)
    {
        $response = $this->json('POST', self::ROUTE, $usuario);
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'access_token'
            ])
            ->assertJson([
                'token_type' => 'bearer'
            ]);

    }

    /**
     * @test
     * @dataProvider usuarioUmProvider
     */

    public function usuario_com_permissao_invalida_no_cad_suas($usuario)
    {
        $response = $this->json('POST', self::ROUTE, $usuario);
        $response
            ->assertStatus(401)
            ->assertJson([
                self::MESSAGE => "Informamos que seu cadastro não se encontra como \"SECRETÁRIO(A) DE ASSISTÊNCIA SOCIAL\"",
            ]);

    }

    /**
     * @test
     */
    public function logout()
    {
        $body = $this->logando();

        $response = $this->withHeaders([
            'Authorization' => 'bearer ' . $body->access_token,
        ])->json('POST', '/api/auth/logout');

        $response
            ->assertStatus(200)
            ->assertJson([self::MESSAGE => 'Successfully logged out']);
    }

    /**
     * @test
     */
    public function informacoes_do_token()
    {
        $body = $this->logando();

        $response = $this->withHeaders([
            'Authorization' => 'bearer ' . $body->access_token,
        ])->json('GET', '/api/auth/me');

        $response
            ->assertStatus(200)
            ->assertJson([
                'id' => '1007430052',
                'cpf' => '01007430052',
                'name' => 'PABLO WANZELLER PINHEIRO',
                'mail' => 'christopher.silva@terceirizado.cidadania.gov.br',
                'type_auth' => 'saa'
            ]);
    }

    private function logando()
    {
        $response = $this->json('POST', self::ROUTE, ['cpf' => '79806503520', self::SENHA => 'mds123']);
        return json_decode($response->getContent());
    }
}
