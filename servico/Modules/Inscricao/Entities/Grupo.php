<?php

namespace Modules\Inscricao\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Grupo
 * @package Modules\Inscricao\Entities
 */
class Grupo extends Model
{
    const CO_GRUPO = 'co_grupo';

    protected $table = 'tb_grupo';
    protected $primaryKey = 'co_grupo';
    public $sequence = 'sq_grupo';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function itens()
    {
        return $this->hasMany(
            Item::class,
            self::CO_GRUPO,
            self::CO_GRUPO
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function itensSemPai()
    {
        return $this->itens()->whereNull('co_formulario_item_insc_pai')->get();
    }
}
