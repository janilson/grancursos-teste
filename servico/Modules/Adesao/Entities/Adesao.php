<?php

namespace Modules\Adesao\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Autenticacao\Entities\Usuario;
use Modules\Coorporativo\Entities\Municipio;
use Modules\Inscricao\Entities\Arquivo;
use Modules\Inscricao\Entities\BloqueioInscricao;
use Modules\Inscricao\Entities\InscricaoEnvio;
use Modules\Inscricao\Entities\Resposta;
use Thalfm\LaravelEloquentFilter\Traits\Filterable;

/**
 * Class Adesao
 * @package Modules\Adesao\Entities
 */
class Adesao extends Model
{
    use Filterable;

    const CO_ADESAO = 'co_adesao';
    const CO_ARQUIVO = 'co_arquivo';
    const CO_MUNICIPIO = 'co_municipio';
    const CO_USUARIO = 'co_usuario';
    const CO_USUARIO_ARQUIVO = 'co_usuario_adesao';

    const CREATED_AT = 'dh_cadastro';
    const UPDATED_AT = null;

    public $sequence = 'sq_adesao';
    public $timestamps = ["created_at"];

    protected $table = 'tb_adesao';
    protected $primaryKey = self::CO_ADESAO;
    protected $fillable = [
        'no_prefeito',
        self::CO_MUNICIPIO,
        'co_arquivo',
        'co_usuario_arquivo',
        'st_adesao_quali',
        'st_pcf_quali',
        'st_progredir_quali',
        'st_paa_quali',
        'st_senapredi_quali',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function servidores()
    {
        return $this->hasMany(
            Servidor::class,
            self::CO_ADESAO,
            self::CO_ADESAO
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function municipio()
    {
        return $this->hasOne(
            Municipio::class,
            self::CO_MUNICIPIO,
            self::CO_MUNICIPIO
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function respostas()
    {
        return $this->hasMany(
            Resposta::class,
            self::CO_ADESAO,
            self::CO_ADESAO
        )->join('tb_formulario_item_inscricao',
            'tb_formulario_item_inscricao.co_formulario_item_inscricao',
            'tb_formulario_resposta.co_formulario_item_inscricao');
    }

    /**
     * @return mixed
     */
    public function pontuacaoTotal()
    {
        return $this->respostas->reduce(function ($carry, Resposta $resposta) {
            return $carry + ($resposta->pontuacaoRespostaValida());
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function respostasHistoricos()
    {
        return $this->hasManyThrough(
            'Modules\Inscricao\Entities\RespostaHistorico',
            'Modules\Inscricao\Entities\Resposta',
            self::CO_ADESAO,
            self::CO_FORMULARIO_RESPOSTA,
            self::CO_ADESAO,
            self::CO_FORMULARIO_RESPOSTA);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function inscricaoEnvios()
    {
        return $this->hasMany(
            InscricaoEnvio::class,
            self::CO_ADESAO,
            self::CO_ADESAO
        );
    }

    /**
     * @return Model|\Illuminate\Database\Eloquent\Relations\HasMany|object|null
     */
    public function ultimoEnvio()
    {
        return $this->inscricaoEnvios()->orderBy('dh_envio', 'desc')->first() ?? null;
    }

    /**
     * @return mixed
     */
    public function ultimoEnvioUsuario()
    {
        return $this->ultimoEnvio()->usuario ?? null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bloqueios()
    {
        return $this->hasMany(BloqueioInscricao::class, self::CO_ADESAO, self::CO_ADESAO);
    }

    /**
     * @return BloqueioInscricao|null
     */
    public function bloqueioAtivo(): ?BloqueioInscricao
    {
        return $this->bloqueios()->where(['st_bloqueio' => 'B'])->first();
    }

    /**
     * @param Usuario $usuario
     * @return bool
     */
    public function existeBloqueio(Usuario $usuario)
    {
        return !is_null($this->bloqueioAtivo()) && (int)$usuario->co_usuario !== (int)$this->bloqueioAtivo()->co_usuario;
    }

    /**
     * @return mixed
     */
    public function municipioGrupo()
    {
        $array = [
            1 => 'Grupo I',
            2 => 'Grupo II',
            3 => 'Grupo III',
            4 => 'Grupo IV',
            5 => 'Grupo V',
        ];

        return $array[(int)$this->municipio->tp_grupo_municipio];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function arquivo()
    {
        return $this->hasOne(
            Arquivo::class,
            self::CO_ARQUIVO,
            self::CO_ARQUIVO
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function usuarioArquivo()
    {
        return $this->hasOne(
            Usuario::class,
            self::CO_USUARIO,
            self::CO_USUARIO_ARQUIVO
        );
    }
}
