<?php

namespace Modules\Inscricao\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\Adesao\Entities\Adesao;
use Modules\Adesao\Entities\Servidor;
use Modules\Autenticacao\Entities\Usuario;

/**
 * Class InscricaoEmail
 * @package Modules\Inscricao\Emails
 */
class InscricaoEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Adesao
     */
    private $adesao;

    /**
     * @var Servidor
     */
    private $servidor;

    /**
     * @var array
     */
    private $representantes;

    /**
     * @var string
     */
    private $caminhoArquivo;

    /**
     * @var bool
     */
    private $temEnvio;

    /**
     * @var Usuario
     */
    private $usuario;

    /**
     * @var \DateTime
     */
    private $data;

    /**
     * InscricaoEmail constructor.
     * @param Adesao $adesao
     * @param Servidor $servidor
     * @param string $caminhoArquivo
     * @param bool $temEnvio
     * @param Usuario $usuario
     */
    public function __construct(Adesao $adesao,
                                Servidor $servidor,
                                string $caminhoArquivo,
                                bool $temEnvio,
                                Usuario $usuario,
                                \DateTime $data)
    {
        $this->adesao = $adesao;
        $this->servidor = $servidor;
        $this->caminhoArquivo = $caminhoArquivo;
        $this->temEnvio = $temEnvio;
        $this->usuario = $usuario;
        $this->data = $data;
        $this->representantes = \Str::replaceLast(', ', ' e ', $this->adesao->servidores->implode('no_servidor', ', '));
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = '';
        $template = '';
        $with = [
            'no_usuario' => $this->servidor->no_servidor,
            'no_municipio' => $this->adesao->municipio->no_municipio,
            'sg_uf' => $this->adesao->municipio->uf->sg_uf,
            'servidores' => $this->adesao->servidores,
            'no_usuario' => $this->usuario->no_usuario
        ];

        if ($this->temEnvio) {
            $subject = 'Edição da ';
            $template = 'editar-';
            $with = [
                'no_usuario' => $this->servidor->no_servidor,
                'no_municipio' => $this->adesao->municipio->no_municipio,
                'sg_uf' => $this->adesao->municipio->uf->sg_uf,
                'no_representantes' => $this->representantes,
                'no_usuario' => $this->usuario->no_usuario,
                'dt_alteracao' => $this->data->format('d/m/Y'),
                'hr_alteracao' => $this->data->format('H:i:s'),
            ];
        }

        return $this
            ->subject("{$subject}Inscrição no Programa Município +Cidadão.")
            ->attach($this->caminhoArquivo)
            ->to($this->servidor->ds_email)
            ->view("inscricao::email.{$template}inscricao")
            ->with($with);
    }
}
