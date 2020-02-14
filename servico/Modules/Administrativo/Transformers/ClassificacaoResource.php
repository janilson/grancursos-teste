<?php

namespace Modules\Administrativo\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Adesao\Transformers\ServidorResource;
use Modules\Inscricao\Entities\Grupo;
use Modules\Inscricao\Transformers\ArquivoResource;

class ClassificacaoResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $dhEnvio = (new \DateTime($this->dh_envio));

        $respostas = json_decode($this->ds_envio);

        $grupos = $this->_grupos($respostas);

        return [
            'co_adesao' => (int)$this->co_adesao,
            'no_municipio' => $this->no_municipio,
            'ds_grupo_municipio' => $this->_municipioGrupo(),
            'sg_uf' => $this->sg_uf,
            'nu_populacao' => number_format($this->nu_populacao, 0, ',', '.'),
            'nu_pontuacao_total' => (int)$this->nu_pontuacao_total,
            'nu_classificacao' => (int)$this->nu_classificacao,
            'nu_posicao' => (int)$this->nu_posicao,
            'st_adesao_quali' => (bool)$this->st_adesao_quali,
            'st_pcf_quali' => (bool)$this->st_pcf_quali,
            'st_progredir_quali' => (bool)$this->st_progredir_quali,
            'st_paa_quali' => (bool)$this->st_paa_quali,
            'st_senapredi_quali' => (bool)$this->st_senapredi_quali,
            'nu_cpf_envio' => preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $this->nu_cpf_envio),
            'no_usuario_envio' => $this->no_usuario_envio,
            'ds_email_envio' => $this->ds_email_envio,
            'dh_envio' => $dhEnvio->format('d/m/Y H:i:s'),
            'has_pre_requisito' => !is_null($this->arquivo),
            'pre_requisito_arquivo' => new ArquivoResource($this->arquivo),
            'grupos' => $grupos,
            'servidores' => ServidorResource::collection($this->servidores)
        ];
    }

    /**
     * @param array $respostas
     * @return array
     */
    private function _grupos(array $respostas): array
    {
        $grupos = [];

        if (count($respostas) <= 0) {
            return $grupos;
        }

        $respostaItens = [];

        foreach ($respostas as $resposta) {
            $respostaItens[$resposta->co_formulario_item_inscricao] = (int)$resposta->st_resposta;
        }

        Grupo::all()->each(function ($grupo, $key) use ($respostaItens, &$grupos) {
            $itens = [];

            $grupo->itens()->each(function ($item) use ($respostaItens, &$itens, &$key) {

                foreach ($respostaItens as $coItem => $stResposta) {
                    $item->st_resposta = 0;
                    if ($item->co_formulario_item_inscricao == $coItem) {
                        $item->st_resposta = $stResposta;
                        break;
                    }
                }

                $novoItem = $item->toArray();

                unset($novoItem['rn']);
                unset($novoItem['co_grupo']);

                $itens[$key][] = $novoItem;
            });

            $grupoNovo = $grupo->toArray();
            $grupoNovo["itens"] = $itens;
            $grupos[] = $grupoNovo;
        });

        return $grupos;
    }

    /**
     * @return mixed
     */
    private function _municipioGrupo()
    {
        $array = [
            1 => 'Grupo I',
            2 => 'Grupo II',
            3 => 'Grupo III',
            4 => 'Grupo IV',
            5 => 'Grupo V',
        ];

        return $array[(int)$this->tp_grupo_municipio];
    }
}
