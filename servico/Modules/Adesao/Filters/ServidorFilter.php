<?php


namespace Modules\Adesao\Filters;


use Thalfm\LaravelEloquentFilter\Filters\SimpleQueryFilter;

class ServidorFilter extends SimpleQueryFilter
{
    protected $simpleFilters = [
        'nu_cpf',
        'no_servidor',
        'co_uf',
        'co_municipio'
    ];

    public function applyNoServidor($value)
    {
        return $this->query->where('no_servidor', 'like', '%'.$value.'%');
    }

    public function applyCoUf($value)
    {
        return $this->query->where('tb_uf.co_uf',  $value);
    }

    public function applyCoMunicipio($value)
    {
        return $this->query->where('tb_municipio.co_municipio',  $value);
    }

    public function apply($query)
    {
        $query
            ->leftJoin('tb_adesao', 'tb_adesao.co_adesao', '=', 'tb_adesao_servidor.co_adesao')
            ->leftJoin('tb_municipio', 'tb_adesao.co_municipio', '=', 'tb_municipio.co_municipio')
            ->leftJoin('tb_uf', 'tb_municipio.co_uf', '=', 'tb_uf.co_uf')
            ->select('*');
        return parent::apply($query);
    }
}