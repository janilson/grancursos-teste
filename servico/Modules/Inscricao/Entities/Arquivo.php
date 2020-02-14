<?php

namespace Modules\Inscricao\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Adesao\Entities\Adesao;

/**
 * Class Arquivo
 * @package Modules\Inscricao\Entities
 */
class Arquivo extends Model
{
    const CO_ADESAO = 'co_adesao';
    const CO_ARQUIVO = 'co_arquivo';

    protected $table = 'tb_arquivo';
    protected $primaryKey = self::CO_ARQUIVO;
    public $sequence = 'sq_arquivo';

    protected $fillable = [
        self::CO_ARQUIVO,
        'no_arquivo',
        'ds_caminho_arquivo',
        'no_extensao',
        'no_mime_type',
        'dh_arquivo',
    ];

    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function adesao()
    {
        return $this->hasOne(
            Adesao::class,
            self::CO_ARQUIVO,
            self::CO_ARQUIVO
        );
    }

    public function getFileName()
    {
        return basename($this->ds_caminho_arquivo . DIRECTORY_SEPARATOR . $this->no_arquivo);
    }
}

