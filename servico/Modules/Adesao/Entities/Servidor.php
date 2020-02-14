<?php

namespace Modules\Adesao\Entities;

use Illuminate\Database\Eloquent\Model;
use Thalfm\LaravelEloquentFilter\Traits\Filterable;

/**
 * Class Servidor
 * @package Modules\Adesao\Entities
 */
class Servidor extends Model
{
    use Filterable;

    const CO_ADESAO = 'co_adesao';
    public $sequence = 'sq_adesao_servidor';
    public $timestamps = false;

    protected $table = 'tb_adesao_servidor';

    protected $primaryKey = 'co_adesao_servidor';

    protected $fillable = [
        "co_adesao",
        "nu_cpf",
        "no_servidor",
        "ds_email",
        "nu_telefone",
        "no_funcao",
        "no_lotacao",
        "st_coordenador",
    ];

    /**
     * @param $value
     */
    public function setNuTelefoneAttribute($value)
    {
        $this->attributes['nu_telefone'] = preg_replace('/[^0-9]/', '', $value);
    }

    /**
     * @param $value
     */
    public function setNuCpfAttribute($value)
    {
        $this->attributes['nu_cpf'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function adesao()
    {
        return $this->belongsTo(Adesao::class,
            self::CO_ADESAO,
            self::CO_ADESAO);
    }
}
