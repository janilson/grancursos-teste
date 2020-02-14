<?php

namespace Modules\Administrativo\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Adesao\Entities\Adesao;
use Modules\Autenticacao\Entities\Usuario;

class HistoricoClassificacao extends Model
{
    const CO_ADESAO = 'co_adesao';
    const CO_CLASSIFICAO = 'co_classificacao';
    const CO_USUARIO = 'co_usuario';
    const NU_CLASSIFICACAO = 'nu_classificacao';
    const NU_POSICAO = 'nu_posicao';
    const NU_PONTUACAO_FINAL = 'nu_pontuacao_final';
    const ST_CLASSIFICACAO = 'st_classificacao';
    const DH_CLASSIFICACAO = 'dh_classificacao';


    protected $table = 'th_classificacao';
    protected $primaryKey = self::CO_CLASSIFICAO;
    public $sequence = 'sq_classificacao';

    protected $fillable = [
        self::CO_CLASSIFICAO,
        self::CO_ADESAO,
        self::CO_USUARIO,
        self::NU_CLASSIFICACAO,
        self::NU_POSICAO,
        self::NU_PONTUACAO_FINAL,
        self::ST_CLASSIFICACAO,
        self::DH_CLASSIFICACAO,
    ];

    public $timestamps = false;

    protected $visible = [];

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
    public function usuario()
    {
        return $this->hasOne(
            Usuario::class,
            self::CO_USUARIO,
            self::CO_USUARIO
        );
    }
}