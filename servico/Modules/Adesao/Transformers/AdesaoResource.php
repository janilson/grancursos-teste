<?php

namespace Modules\Adesao\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Inscricao\Transformers\ArquivoResource;

/**
 * Class AdesaoResource
 * @package Modules\Adesao\Transformers
 */
class AdesaoResource extends Resource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     * @throws \Exception
     */
    public function toArray($request)
    {
        $ultimoEnvio = $this->ultimoEnvio();
        $ultimoEnvioUsuario = $this->ultimoEnvioUsuario();

        $dhEnvio = (new \DateTime($ultimoEnvio->dh_envio ?? ''));

        return [
            'co_adesao' => (integer)$this->co_adesao,
            'no_prefeito' => $this->no_prefeito,
            'no_uf' => $this->sg_uf,
            'no_regiao' => $this->no_regiao,
            'no_municipio' => $this->no_municipio,
            'tp_grupo_municipio' => $this->municipioGrupo(),
            'nu_populacao' => number_format($this->nu_populacao, 0, ',', '.'),
            'nu_pontuacao_total' => $this->pontuacaoTotal(),
            'existe_envio' => $this->st_envio == 'E',
            'ds_situacao' => $this->st_envio == 'E' ? 'Enviado' : 'Pendente',
            'nu_cpf_envio' => $ultimoEnvioUsuario->nu_cpf ?? '',
            'no_usuario_envio' => $ultimoEnvioUsuario->no_usuario ?? '',
            'ds_email_envio' => $ultimoEnvioUsuario->ds_email ?? '',
            'dh_envio' => $dhEnvio->format('d/m/Y H:i:s'),
            'has_pre_requisito' => !is_null($this->arquivo),
            'pre_requisito_arquivo' => new ArquivoResource($this->arquivo),
            'servidores' => ServidorResource::collection($this->servidores)
        ];
    }
}
