<?php

namespace Modules\Autenticacao\Entities;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Autorizacao\Entities\Allowable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class Usuario
 * @package Modules\Autenticacao\Entities
 */
class Usuario extends Authenticatable implements JWTSubject, Allowable
{
    const CO_USUARIO = 'co_usuario';
    const NO_USUARIO = 'no_usuario';
    const NU_CPF = 'nu_cpf';
    const DS_EMAIL = 'ds_email';
    const DS_SENHA = 'ds_senha';
    const TP_PERFIL = 'tp_perfil';
    const CO_ADESAO = 'co_adesao';

    protected $table = 'tb_usuario';

    protected $primaryKey = self::CO_USUARIO;

    protected $sequence = 'sq_usuario';

    private $senhaPura;

    protected $fillable = [
        self::NO_USUARIO,
        self::NU_CPF,
        self::DS_EMAIL,
        self::TP_PERFIL,
        self::DS_SENHA,
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        self::DS_SENHA,
    ];

    public $timestamps = false;

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->nu_cpf;
    }

    /**
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getJWTIdentifier();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {

        $dadosPayload = [
            'user' => [
                self::CO_USUARIO => $this->co_usuario,
                self::NO_USUARIO => $this->no_usuario,
                self::NU_CPF => $this->nu_cpf,
                self::DS_EMAIL => $this->ds_email,
                self::TP_PERFIL => $this->tp_perfil
            ]
        ];

        return $dadosPayload;
    }

    /**
     * @param $ds_senha
     */
    public function setDsSenhaAttribute($ds_senha)
    {
        $this->senhaPura = $ds_senha;
        $this->attributes[self::DS_SENHA] = password_hash(
            $ds_senha,
            PASSWORD_DEFAULT
        );
    }

    /**
     * @return string
     */
    public function getSenhaPura(): string
    {
        return $this->senhaPura ?: '';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function adesoes()
    {
        return $this->hasManyThrough(
            'Modules\Adesao\Entities\Adesao',
            'Modules\Adesao\Entities\Servidor',
            self::NU_CPF,
            self::CO_ADESAO,
            self::NU_CPF,
            self::CO_ADESAO);
    }

    public function getProfileName(): ?string
    {
        return $this->tp_perfil;
    }
}
