<?php

namespace Modules\Inscricao\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Modules\Adesao\Entities\Adesao;
use Modules\Autenticacao\Entities\Usuario;

/**
 * Class InscricaoEnvio
 * @package Modules\Inscricao\Entities
 * @method static InscricaoEnvio ultimoEnvio(int $co_adesao)
 */
class InscricaoEnvio extends Model
{
    const CO_ADESAO = 'co_adesao';
    const CO_INSCRICAO_ENVIO = 'co_inscricao_envio';
    const CO_USUARIO_ENVIO = 'co_usuario_envio';

    protected $table = 'tb_inscricao_envio';
    protected $primaryKey = self::CO_INSCRICAO_ENVIO;
    public $sequence = 'sq_inscricao_envio';

    protected $fillable = [
        self::CO_ADESAO,
        self::CO_USUARIO_ENVIO,
        'ds_envio',
        'ds_caminho_arquivo',
        'dh_envio',
        'nu_pontuacao_atual'
    ];

    public $timestamps = false;

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
            'co_usuario',
            self::CO_USUARIO_ENVIO
        );
    }

    /**
     * @param Builder $query
     * @param $co_adesao
     * @return mixed
     */
    public static function scopeUltimoEnvio($query, $co_adesao)
    {
        return $query->select()
            ->where('co_inscricao_envio', function ($query) use ($co_adesao) {
                /** @var Builder $query */
                $query
                    ->select(\DB::raw('max(co_inscricao_envio)'))
                    ->from('tb_inscricao_envio')
                    ->where('co_adesao', $co_adesao)
                    ->groupBy('co_adesao');
            })->first();
    }

    public function getFileName()
    {
        return basename($this->ds_caminho_arquivo);
    }
}
