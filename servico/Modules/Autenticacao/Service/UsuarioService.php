<?php

namespace Modules\Autenticacao\Service;

use App\Exceptions\UnauthorizedException;
use Illuminate\Contracts\Auth\Guard;
use Modules\Autenticacao\Entities\Usuario;
use Modules\Autenticacao\Repository\UsuarioRepositoryInterface;

/**
 * Class UsuarioService
 * @package Modules\Autenticacao\Service
 */
class UsuarioService
{
    /**
     * @var UsuarioRepositoryInterface
     */
    private $usuarioRepository;

    /**
     * @var Guard
     */
    private $guard;

    /**
     * UsuarioService constructor.
     * @param UsuarioRepositoryInterface $usuarioRepository
     * @param Guard $guard
     */
    public function __construct(UsuarioRepositoryInterface $usuarioRepository, Guard $guard)
    {
        $this->usuarioRepository = $usuarioRepository;
        $this->guard = $guard;
    }

    /**
     * @return Usuario
     */
    public function getUsuarioLogado(): Usuario
    {
        if (!$this->guard->user()) {
            throw new UnauthorizedException();
        }

        $cpf = $this->guard->user()->getAuthIdentifier();
        return $this->usuarioRepository->findByCpf($cpf);
    }

    public function desbloquearInscricao(Usuario $usuario)
    {
        return $this->usuarioRepository->desbloquearInscricao($usuario);
    }
}