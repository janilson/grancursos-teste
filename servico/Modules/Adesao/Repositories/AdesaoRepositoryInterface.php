<?php

namespace Modules\Adesao\Repositories;

use Modules\Adesao\Entities\Adesao;

/**
 * Interface AdesaoRepositoryInterface
 * @package Modules\Adesao\Repositories
 */
interface AdesaoRepositoryInterface
{
    /**
     * @param array $dados
     * @return Adesao
     */
    public function criar(array $dados): Adesao;

    /**
     * @param array $listaCpf
     * @return array|null
     */
    public function quantidadeDeAdesoesPorCpf(array $listaCpf): ?array;
}