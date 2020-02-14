<?php

namespace Modules\Autenticacao\Repository;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Modules\Autenticacao\Entities\Usuario;

/**
 * Interface UsuarioRepositoryInterface
 * @package Modules\Autenticacao\Repository
 */
interface UsuarioRepositoryInterface
{
    /**
     * @return Model
     */
    public function getModel(): Model;

    /**
     * @param string $cpf
     * @return Usuario|null
     */
    public function findByCpf(string $cpf): ?Usuario;

    /**
     * @param Usuario $usuario
     * @return Usuario
     */
    public function gerarSenhaAutomatica(Usuario $usuario): Usuario;

    public function desbloquearInscricao(Usuario $usuario): bool;

    public function cadastrarUsuarios(Command $command): Collection;
}