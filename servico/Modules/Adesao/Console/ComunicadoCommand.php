<?php

namespace Modules\Adesao\Console;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Adesao\Imports\ServidoresImport;

class ComunicadoCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'comunicado:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

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
        $path = storage_path('app/SERVIDORES_REPRESENTANTES.xls');
        Excel::import(new ServidoresImport, $path);

        $this->output->success('Comunicado enviado');
    }
}
