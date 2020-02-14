<?php


namespace Modules\Inscricao\Entities;


use Illuminate\Database\Eloquent\Model;
use Modules\Autenticacao\Entities\Usuario;

class BloqueioInscricao extends Model
{
    const TB_BLOQUEIO_INSCRICAO = 'tb_bloqueio_inscricao';
    const CO_BLOQUEIO_INSCRICAO = 'co_bloqueio_inscricao';
    const CO_ADESAO = 'co_adesao';
    const CO_USUARIO = 'co_usuario';
    const ST_BLOQUEIO = 'st_bloqueio';
    const DH_BLOQUEIO = 'dh_bloqueio';

//    public $sequence = 'sq_bloqueio_inscricao';
    public $timestamps = false;

    protected $table = self::TB_BLOQUEIO_INSCRICAO;
    protected $primaryKey = self::CO_BLOQUEIO_INSCRICAO;

    protected $fillable = [
        self::CO_ADESAO,
        self::CO_USUARIO,
        self::ST_BLOQUEIO,
        self::DH_BLOQUEIO
    ];

    public function usuario()
    {
        return $this->hasOne(Usuario::class, self::CO_USUARIO, self::CO_USUARIO);
    }

}