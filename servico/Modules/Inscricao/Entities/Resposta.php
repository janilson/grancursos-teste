<?php

namespace Modules\Inscricao\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Adesao\Entities\Adesao;
use Modules\Autenticao\Entities\Usuario;

/**
 * Class Resposta
 * @package Modules\Inscricao\Entities
 */
class Resposta extends Model
{
    const CO_ADESAO = 'co_adesao';
    const CO_FORMULARIO_ITEM_INSCRICAO = 'co_formulario_item_inscricao';
    const CO_FORMULARIO_RESPOSTA = 'co_formulario_resposta';
    const ST_RESPOSTA = 'st_resposta';

    protected $table = 'tb_formulario_resposta';
    protected $primaryKey = self::CO_FORMULARIO_RESPOSTA;
    public $sequence = 'sq_formulario_resposta';

    protected $fillable = [
        self::CO_FORMULARIO_ITEM_INSCRICAO,
        self::CO_ADESAO,
        'co_usuario_cadastro',
        'dh_resposta',
        self::ST_RESPOSTA
    ];

    public $timestamps = false;

    protected $visible = [
        self::CO_FORMULARIO_RESPOSTA,
        self::CO_FORMULARIO_ITEM_INSCRICAO,
        self::ST_RESPOSTA
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function adesao()
    {
        return $this->hasOne(
            Adesao::class,
            self::CO_ADESAO,
            self::CO_ADESAO
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function item()
    {
        return $this->hasOne(
            Item::class,
            self::CO_FORMULARIO_ITEM_INSCRICAO,
            self::CO_FORMULARIO_ITEM_INSCRICAO
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function usuario()
    {
        return $this->hasOne(
            \Modules\Autenticacao\Entities\Usuario::class,
            'co_usuario',
            'co_usuario_criacao'
        );
    }

    /**
     * @return mixed
     */
    public function grupo()
    {
        return $this->item->grupo;
    }

    /**
     * @return int
     */
    public function pontuacaoRespostaValida()
    {
        return $this->st_resposta ? $this->item->nu_pontuacao : 0;
    }
}
