<?php

namespace Modules\Adesao\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ComunicadoMail extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var string
     */
    private $email;

    /**
     * CominicadoMail constructor.
     * @param string $email
     */
    public function __construct(string $email)
    {
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject("Comunicado da Coordenação do Programa Município Mais Cidadão.")
            ->attach(storage_path('app/PORTARIA.pdf'))
            ->to($this->email)
            ->view("adesao::email.comunicado");
    }
}
