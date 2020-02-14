<?php

namespace Modules\Adesao\Services;

use Modules\Adesao\Entities\Adesao;
use Modules\Adesao\Exceptions\JaExisteCpfCadastradoEmAdesaoException;
use Modules\Adesao\Exceptions\JaExisteTermoAdesaoParaMunicipioException;
use Modules\Adesao\Http\Requests\AdesaoRequest;
use Modules\Adesao\Repositories\AdesaoRepository;

/**
 * Class AdesaoService
 * @package Modules\Adesao\Services
 */
class AdesaoService
{
    /**
     * @var AdesaoRepository
     */
    private $adesaoRepository;

    /**
     * AdesaoService constructor.
     * @param AdesaoRepository $adesaoRepository
     */
    public function __construct(AdesaoRepository $adesaoRepository)
    {
        $this->adesaoRepository = $adesaoRepository;
    }

    /**
     * @param AdesaoRequest $request
     * @return Adesao
     * @throws \Exception
     */
    public function criar(AdesaoRequest $request)
    {
        $this->municipioJaCadastradoEmAlgumaAdesao($request->get('co_municipio'));
//        $this->cpfJaExistaEmAlgumaAdesao($request->getListaCpfServidores());
        return $this->adesaoRepository->criar($request->all());
    }

    /**
     * @param Adesao $adesao
     * @return \Illuminate\Http\Response
     */
    public function baixarPdf(Adesao $adesao)
    {
        return \PDF::loadView(
            'adesao::termo-adesao',
            ['adesao' => $adesao]
        )->download('termo-adesao.pdf');
    }

    /**
     * @param array $listaCpf
     * @return bool
     */
    private function cpfJaExistaEmAlgumaAdesao(array $listaCpf): bool
    {
        $quantidadeDeAdesoesPorCpf = $this->adesaoRepository
            ->quantidadeDeAdesoesPorCpf($listaCpf);

        if (!$quantidadeDeAdesoesPorCpf) {
            return false;
        }

        $cpfFormatado = array_map(function ($value) {
            return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $value);
        }, $quantidadeDeAdesoesPorCpf);

        throw new JaExisteCpfCadastradoEmAdesaoException($cpfFormatado);
    }

    /**
     * @param int $co_ibge
     * @return bool
     */
    private function municipioJaCadastradoEmAlgumaAdesao(int $co_ibge)
    {
        $quantidadeDeAdesoesPorMunicipio = $this->adesaoRepository
            ->quantidadeDeAdesoesPorMunicipio($co_ibge);

        if (!$quantidadeDeAdesoesPorMunicipio) {
            return false;
        }

        throw new JaExisteTermoAdesaoParaMunicipioException();
    }
}