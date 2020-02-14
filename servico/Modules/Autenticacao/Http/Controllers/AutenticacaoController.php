<?php

namespace Modules\Autenticacao\Http\Controllers;

use App\Exceptions\ForbidenException;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Autenticacao\Entities\Usuario;
use Modules\Autenticacao\Http\Requests\AuthRequest;
use Modules\Autenticacao\Http\Requests\RecuperarSenhaRequest;
use Modules\Autenticacao\Service\SenhaService;
use Modules\Autenticacao\Service\UsuarioService;

/**
 * Class AutenticacaoController
 * @package Modules\Autenticacao\Http\Controllers
 */
class AutenticacaoController extends Controller
{
    /**
     * @var Guard
     */
    private $guard;
    /**
     * @var SenhaService
     */
    private $recuperarSenhaService;
    /**
     * @var UsuarioService
     */
    private $usuarioService;

    /**
     * AutenticacaoController constructor.
     * @param Guard $guard
     * @param SenhaService $recuperarSenhaService
     */
    public function __construct(
        Guard $guard,
        SenhaService $recuperarSenhaService,
        UsuarioService $usuarioService
    )
    {
        $this->guard = $guard;
        $this->recuperarSenhaService = $recuperarSenhaService;
        $this->usuarioService = $usuarioService;
    }

    /**
     * @param AuthRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(AuthRequest $request)
    {
        $credentials = $request->all(['nu_cpf', 'ds_senha']);

        if (!$token = $this->guard->attempt($credentials)) {
            throw new ForbidenException();
        }

        return $this->respondWithToken($token);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $user = $this->guard->user();
        return response()->json($user);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        /** @var Usuario $usuario */
        $usuario = $this->guard->user();
        $this->guard->logout();
        $this->usuarioService->desbloquearInscricao($usuario);
        return response()->json(['message' => 'Successfully logged out'], Response::HTTP_NO_CONTENT);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard->refresh());
    }

    /**
     * @param $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard->factory()->getTTL() * 240
        ]);
    }

    /**
     * @param RecuperarSenhaRequest $request
     * @throws \Exception
     */
    public function recuperarSenha(RecuperarSenhaRequest $request)
    {
        $this->recuperarSenhaService->recuperar($request->all());
    }
}
