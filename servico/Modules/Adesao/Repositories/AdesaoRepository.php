<?php

namespace Modules\Adesao\Repositories;

use Modules\Adesao\Entities\Adesao;
use Modules\Adesao\Entities\Servidor;

/**
 * Class AdesaoRepository
 * @package Modules\Adesao\Repositories
 */
class AdesaoRepository implements AdesaoRepositoryInterface
{
    /**
     * @var Adesao
     */
    private $adesao;

    /**
     * AdesaoRepository constructor.
     * @param Adesao $adesao
     */
    public function __construct(Adesao $adesao)
    {
        $this->adesao = $adesao;
    }

    /**
     * @param array $dados
     * @return Adesao
     * @throws \Exception
     */
    public function criar(array $dados): Adesao
    {
        try {
            \DB::beginTransaction();

            /** @var Adesao $adesaoCriada */
            $adesaoCriada = $this->adesao->create($dados);

            $adesaoCriada->servidores()->createMany($dados['servidores'] ?? []);

            \DB::commit();
        } catch (\Exception $exception) {
            \DB::rollBack();
            throw $exception;
        }

        return $adesaoCriada;
    }

    /**
     * @param array $listaCpf
     * @return array|null
     */
    public function quantidadeDeAdesoesPorCpf(array $listaCpf): ?array
    {
        return Servidor::select(\DB::raw('count(co_adesao) as quantidade, nu_cpf'))
            ->whereIn('nu_cpf', $listaCpf)
            ->groupBy('nu_cpf')
            ->get()
            ->toArray() ?: null;
    }

    /**
     * @param int $co_municipio
     * @return int
     */
    public function quantidadeDeAdesoesPorMunicipio(int $co_municipio): int
    {
        return Adesao::where('co_municipio', $co_municipio)->count();
    }
}