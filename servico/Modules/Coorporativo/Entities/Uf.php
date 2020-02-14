<?php


namespace Modules\Coorporativo\Entities;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Uf
 * @package Modules\Coorporativo\Entities
 */
class Uf extends Model
{
    const CO_UF = 'co_uf';

    protected $table = 'tb_uf';
    protected $primaryKey = 'co_uf';
    public $sequence = 'sq_uf';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function municipios()
    {
        return $this->hasMany(Municipio::class, self::CO_UF, self::CO_UF);
    }
}