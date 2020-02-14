<?php

namespace Modules\Inscricao\Console;

use Illuminate\Console\Command;
use Modules\Inscricao\Services\BloqueioInscricaoService;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class BloqueioInscricao extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'command:bloqueio';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica os bloqueios das inscrições..';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $total = BloqueioInscricaoService::verificarBloqueio();
        $this->output->success("Quantidade de inscrições desbloqueadas: {$total};");
    }
}
