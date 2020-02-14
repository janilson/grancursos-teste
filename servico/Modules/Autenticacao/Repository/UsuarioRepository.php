<?php

namespace Modules\Autenticacao\Repository;

use DB;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Modules\Adesao\Entities\Servidor;
use Modules\Autenticacao\Emails\GerarSenhaMail;
use Modules\Autenticacao\Entities\Usuario;
use Modules\Inscricao\Entities\BloqueioInscricao;

/**
 * Class UsuarioRepository
 * @package Modules\Autenticacao\Repository
 */
class UsuarioRepository implements UsuarioRepositoryInterface
{
    private $usuario;

    /**
     * UsuarioRepository constructor.
     * @param Usuario $usuario
     */
    public function __construct(Usuario $usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->usuario;
    }

    /**
     * @param string $cpf
     * @return Usuario|null
     */
    public function findByCpf(string $cpf): ?Usuario
    {
        return $this->getModel()
            ->where('nu_cpf', $cpf)
            ->first() ?: null;
    }

    /**
     * @param Usuario $usuario
     * @return Usuario
     */
    public function gerarSenhaAutomatica(Usuario $usuario): Usuario
    {
        $novaSenha = Str::random(8);
        $usuario->ds_senha = $novaSenha;
        $usuario->save();
        return $usuario;
    }

    /**
     * @param Usuario $usuario
     * @return bool
     */
    public function desbloquearInscricao(Usuario $usuario): bool
    {
        return BloqueioInscricao::where(['co_usuario' => $usuario->co_usuario])
            ->update(['st_bloqueio' => 'D']);
    }

    /**
     * @return Collection
     */
    public function cadastrarUsuarios(Command $command): Collection
    {
        $usuarios = new Collection();

        Servidor::select([
            'tb_adesao_servidor.no_servidor',
            'tb_adesao_servidor.nu_cpf',
            'tb_adesao_servidor.ds_email',
        ])
            ->leftJoin('tb_usuario',
                'tb_usuario.nu_cpf',
                '=',
                'tb_adesao_servidor.nu_cpf')
            ->whereNull('tb_usuario.co_usuario')
            ->limit(20)
            ->get()
            ->each(function (Servidor $servidor) use ($command, $usuarios) {
                try {
                    $arServidor = $servidor->toArray();

                    $command->getOutput()->note("Inserindo o Servidor: {$arServidor['no_servidor']}; CPF: {$arServidor['nu_cpf']}; E-mail: {$arServidor['ds_email']}");

                    DB::beginTransaction();

                    $novoUsuario = new Usuario();
                    $novoUsuario->no_usuario = (string)$arServidor['no_servidor'];
                    $novoUsuario->nu_cpf = (string)$arServidor['nu_cpf'];
                    $novoUsuario->ds_email = (string)$arServidor['ds_email'];
                    $novoUsuario->tp_perfil = 'E';
                    $novoUsuario->ds_senha = Str::random(8);

                    $novoUsuario->save();

                    DB::commit();

                    $usuarios->push($novoUsuario);

                    try {
                        \Mail::send(new GerarSenhaMail($novoUsuario));
                    } catch (\Exception $exception) {
                        $command->getOutput()->warning('Erro no envio de mail: ' . $exception->getMessage());
                    }
                } catch (\Exception $exception) {
                    DB::rollBack();
                }
            });

        return $usuarios;
    }
}