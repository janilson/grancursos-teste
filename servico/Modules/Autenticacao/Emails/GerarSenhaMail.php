<?php

namespace Modules\Autenticacao\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\Autenticacao\Entities\Usuario;

class GerarSenhaMail extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var Usuario
     */
    private $usuario;


    public function __construct(Usuario $usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Senha para Acesso ao Sistema de Inscrição do Programa Município + Cidadão.')
            ->to($this->usuario->ds_email)
            ->view('autenticacao::email.gerar-senha')
            ->with([
                'no_usuario' =>  $this->usuario->no_usuario,
                'no_url' => env('MAIS_CIDADAO_HOST'),
                'ds_senha' => $this->usuario->getSenhaPura(),
            ]);
    }
}
