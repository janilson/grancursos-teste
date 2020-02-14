<?php

namespace Modules\Administrativo\Services;

use DB;
use Illuminate\Database\Eloquent\Collection;
use Modules\Adesao\Entities\Adesao;
use Modules\Administrativo\Entities\HistoricoClassificacao;
use Modules\Administrativo\Exceptions\AdesaoInvalidaException;
use Modules\Administrativo\Exceptions\ErroAoSalvarHistoricoClassificacaoException;
use Modules\Administrativo\Filters\ClassificacaoFilter;
use Modules\Autenticacao\Entities\Usuario;

/**
 * Class InscricaoService
 * @package Modules\Inscricao\Services
 */
class AdministrativoService
{
    /**
     * @return mixed
     */
    public function obterClassicacoes()
    {
        $classificacoes = Adesao::filtered(\App::make(ClassificacaoFilter::class));

        return $classificacoes;
    }

    /**
     * @param Adesao $adesao
     * @return Collection|null
     */
    public function obterClassicacaoAdesao(Adesao $adesao)
    {
        $classificacao = Adesao::filtered(\App::make(ClassificacaoFilter::class))
            ->where('co_adesao', '=', $adesao->co_adesao)
            ->get()
            ->first();

        if (!$classificacao) {
            throw new AdesaoInvalidaException();
        }

        return $classificacao;
    }

    /**
     * @param \DateTime $data
     * @param Usuario $usuario
     * @return array
     * @throws \Exception
     */
    public function aprovarClassificados(\DateTime $data, Usuario $usuario = null, $st_classificacao = 'T')
    {
        try {
            DB::beginTransaction();

            $classificados = $this->obterClassicacoes();
            foreach ($classificados as $classificado) {

                $create = HistoricoClassificacao::create([
                    'co_adesao' => $classificado['co_adesao'],
                    'co_usuario' => $usuario->co_usuario ?? null,
                    'nu_classificacao' => (int)$classificado['nu_classificacao'],
                    'nu_posicao' => (int)$classificado['nu_posicao'],
                    'nu_pontuacao_final' => (int)$classificado['nu_pontuacao_total'],
                    'st_classificacao' => $st_classificacao,
                    'dh_classificacao' => $data->format('Y-m-d H:i:s'),
                ]);

                if (!$create) {
                    throw new ErroAoSalvarHistoricoClassificacaoException();
                }
            }

            DB::commit();

            return [
                'code' => 202,
                'message' => "Operação realizada com sucesso!"
            ];
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}