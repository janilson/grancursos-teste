<?php

namespace Modules\Autenticacao\Providers;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\ServiceProvider;
use Modules\Autenticacao\Entities\Usuario;
use Modules\Autenticacao\Exceptions\CpfNaoLocalizadoException;
use Modules\Autenticacao\Exceptions\SenhaNaoConfereException;

/**
 * Class AutenticacaoProvider
 * @package Modules\Autenticacao\Providers
 */
class AutenticacaoProvider implements UserProvider
{
    private $autenticado = false;

    /**
     * Retrieve a user by their unique identifier.
     *
     * @param mixed $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        $data = $this->retrieveDataUser();
        $usuario = new Usuario($this->retrieveDataUser());

        $usuario->co_usuario = $data['co_usuario'] ?? '';

        return $usuario;
    }

    /**
     * @return array
     */
    private function retrieveDataUser(): array
    {
        $dadosUsuario = auth()->payload()->toArray();
        if (array_key_exists('user', $dadosUsuario)) {
            return (array)$dadosUsuario['user'];
        }
        return [];
    }

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     *
     * @param mixed $identifier
     * @param string $token
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByToken($identifier, $token)
    {
        return true;
    }

    /**
     * Update the "remember me" token for the given user in storage.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param string $token
     * @return void
     */
    public function updateRememberToken(Authenticatable $user, $token)
    {
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param array $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        $usuario = Usuario::where(
            'nu_cpf',
            $credentials['nu_cpf']
        )->first();

        if (!$usuario) {
            throw new CpfNaoLocalizadoException();
        }

        $usuarioValido = password_verify($credentials['ds_senha'], $usuario->ds_senha);
        if (!$usuarioValido) {
            throw new SenhaNaoConfereException();
        }

        $this->autenticado = true;

        return $usuario;
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param array $credentials
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        return $this->autenticado;
    }
}
