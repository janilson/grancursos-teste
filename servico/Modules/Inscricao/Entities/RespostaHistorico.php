<?php

namespace Modules\Inscricao\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Autenticacao\Entities\Usuario;
use Thalfm\LaravelEloquentFilter\Traits\Filterable;

/**
 * Class RespostaHistorico
 * @package Modules\Inscricao\Entities
 */
class RespostaHistorico extends Model
{
    use Filterable;

    const CO_FORMULARIO_RESPOSTA = 'co_formulario_resposta';
    const CO_USUARIO = 'co_usuario';

    public $sequence = 'sq_resposta';
    protected $table = 'th_resposta';
    protected $primaryKey = 'co_resposta';

    public $timestamps = false;

    protected $fillable = [
        self::CO_FORMULARIO_RESPOSTA,
        self::CO_USUARIO,
        'st_resposta_antiga',
        'st_resposta_atual',
        'dh_resposta',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function resposta()
    {
        return $this->hasOne(
            Resposta::class,
            self::CO_FORMULARIO_RESPOSTA,
            self::CO_FORMULARIO_RESPOSTA
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function usuario()
    {
        return $this->hasOne(
            Usuario::class,
            self::CO_USUARIO,
            self::CO_USUARIO
        );
    }

    /**
     * @return mixed
     */
    public function grupo()
    {
        return $this->resposta->item->grupo;
    }
}
