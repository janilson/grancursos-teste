<?php

namespace Modules\Autenticacao\Service;

use DB;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Mail;
use Modules\Autenticacao\Emails\RecuperarSenhaMail;
use Modules\Autenticacao\Entities\Usuario;
use Modules\Autenticacao\Exceptions\CpfNaoLocalizadoException;
use Modules\Autenticacao\Exceptions\EmailNaoCorrespondeCpfException;
use Modules\Autenticacao\Repository\UsuarioRepositoryInterface;

/**
 * Class RecuperarSenhaService
 * @package Modules\Autenticacao\Service
 */
class SenhaService
{
    /**
     * @var UsuarioRepositoryInterface
     */
    private $usuarioRepository;

    /**
     * RecuperarSenhaService constructor.
     * @param UsuarioRepositoryInterface $usuarioRepository
     */
    public function __construct(UsuarioRepositoryInterface $usuarioRepository)
    {
        $this->usuarioRepository = $usuarioRepository;
    }

    /**
     * @param array $dados
     * @return Usuario|null
     * @throws Exception
     */
    public function recuperar(array $dados)
    {
        $usuario = $this->usuarioRepository
            ->findByCpf($dados['nu_cpf'] ?? '');

        if (!$usuario) {
            throw new CpfNaoLocalizadoException();
        }

        if ($usuario->ds_email != ($dados['ds_email'] ?? '')) {
            throw new EmailNaoCorrespondeCpfException();
        }

        try {
            DB::beginTransaction();

            $this->usuarioRepository
                ->gerarSenhaAutomatica($usuario);

            Mail::send(new RecuperarSenhaMail($usuario));

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

        return $usuario;
    }

    /**
     * @return Collection
     */
    public function gerar(Command $command): Collection
    {
        $usuariosCadastrados = new Collection();

        try {
            $usuariosCadastrados = $this->usuarioRepository->cadastrarUsuarios($command);
        } catch (Exception $exception) {
            $usuariosCadastrados = new Collection();
            //throw $exception;
            // @todo deixando propagar e fica no log os erros na aplicação.
        }
        return $usuariosCadastrados;
    }
}