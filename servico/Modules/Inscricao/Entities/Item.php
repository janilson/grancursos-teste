<?php

namespace Modules\Inscricao\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Item
 * @package Modules\Inscricao\Entities
 */
class Item extends Model
{
    const CO_GRUPO = 'co_grupo';
    const CO_FORMULARIO_ITEM_INSCRICAO = 'co_formulario_item_inscricao';

    protected $table = 'tb_formulario_item_inscricao';
    protected $primaryKey = 'co_formulario_item_inscricao';
    public $sequence = 'sq_formulario_item_inscricao';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function grupo()
    {
        return $this->hasOne(
            Grupo::class,
            self::CO_GRUPO,
            self::CO_GRUPO
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function pai()
    {
        return $this->hasOne(
            Item::class,
            'co_formulario_item_inscricao',
            'co_formulario_item_insc_pai'
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function filhas()
    {
        return $this->hasMany(
            Item::class,
            'co_formulario_item_insc_pai',
            'co_formulario_item_inscricao'
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function respostas()
    {
        return $this->hasMany(
            Resposta::class,
            'co_formulario_item_inscricao',
            'co_formulario_item_inscricao'
        );
    }

    /**
     * @param int $co_adesao
     * @return Model|\Illuminate\Database\Eloquent\Relations\HasOne|object|null
     */
    public function respostaAdesao($co_adesao)
    {
        $resposta = $this->respostas()->where('co_adesao', $co_adesao)->first();
        $this->co_formulario_resposta = $resposta->co_formulario_resposta ?? 0;
        $this->st_resposta = $resposta->st_resposta ?? 0;
    }

    public function descricaoPai()
    {
        return $this->pai->ds_formulario_item_inscricao ?? "";
    }
}
