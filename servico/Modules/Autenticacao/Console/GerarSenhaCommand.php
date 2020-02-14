<?php

namespace Modules\Autenticacao\Console;

use Exception;
use Illuminate\Console\Command;
use Modules\Autenticacao\Service\SenhaService;

class GerarSenhaCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'usuarios:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria os usuários a partir dos servidores e envia a senha por e-mail';
    /**
     * @var SenhaService
     */
    private $senhaService;

    public function __construct(SenhaService $senhaService)
    {
        parent::__construct();
        $this->senhaService = $senhaService;
    }


    /**
     * @throws Exception
     */
    public function handle()
    {

        if (date('Y-m-d') < env('DATA_CRIACAO_USUARIOS')) {
            $this->output->warning('Ainda não esta na data de execução!');
            exit();
        }

        $usuariosCadastrados = $this->senhaService->gerar($this);
        $quantidadeDeUsuariosCadastrados = $usuariosCadastrados->count();
        if ($quantidadeDeUsuariosCadastrados) {
            $this->output->success("Quantidade de usuários cadastrados: $quantidadeDeUsuariosCadastrados");
            $this->output->success('Usuários criados com sucesso!');
            exit();
        }

        $this->output->warning('Nenhum usuário para ser cadastrado!');
    }
}
