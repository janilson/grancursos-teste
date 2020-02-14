<?php


namespace Modules\Coorporativo\Entities;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Municipio
 * @package Modules\Coorporativo\Entities
 */
class Municipio extends Model
{
    const CO_UF = 'co_uf';

    protected $table = 'tb_municipio';
    protected $primaryKey = 'co_municipio';
    public $sequence = 'sq_municipio';
    protected $fillable = [
        'no_municipio',
        self::CO_UF,
        'co_ibge'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function uf()
    {
        return $this->hasOne(
            Uf::class,
            self::CO_UF,
            self::CO_UF
        );
    }
}