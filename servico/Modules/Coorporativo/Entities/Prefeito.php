<?php


namespace Modules\Coorporativo\Entities;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Prefeito
 * @package Modules\Coorporativo\Entities
 */
class Prefeito extends Model
{
    protected $fillable = [
        'co_uf',
        'co_municipio_ibge',
        'no_cidade',
        'no_dirigente',
        'dt_inicio_mandato',
        'dt_fim_mandato',
    ];
}