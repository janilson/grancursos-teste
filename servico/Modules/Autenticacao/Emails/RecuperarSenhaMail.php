<?php

namespace Modules\Autenticacao\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Autenticacao\Entities\Usuario;

/**
 * Class RecuperarSenhaMail
 * @package Modules\Autenticacao\Emails
 */
class RecuperarSenhaMail extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var Usuario
     */
    private $usuario;

    /**
     * RecuperarSenhaMail constructor.
     * @param Usuario $usuario
     */
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
            ->subject('Senha para Acesso ao Sistema de Inscrição do Programa Município +Cidadão.')
            ->to($this->usuario->ds_email)
            ->view('autenticacao::email.recuperar-senha')
            ->with([
                'no_usuario' => $this->usuario->no_usuario,
                'nu_cpf' => $this->usuario->nu_cpf,
                'ds_senha' => $this->usuario->getSenhaPura(),
                'data' => date('d/m/Y'),
                'hora' => date('H:i:s'),
                'host' => env('MAIS_CIDADAO_HOST')
            ]);
    }
}
