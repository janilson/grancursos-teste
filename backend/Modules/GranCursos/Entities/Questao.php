<?php

namespace Modules\GranCursos\Entities;

use Illuminate\Database\Eloquent\Model;

class Questao extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'id_questao';
    protected $table = 'tb_questao';

    protected $fillable = [
        'id_questao',
        'no_questao',
        'id_assunto',
        'id_banca',
        'id_orgao',
    ];

    protected $visible = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function assunto()
    {
        return $this->hasOne('Assunto',
            'id_assunto',
            'id_assunto');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function banca()
    {
        return $this->hasOne('Banca',
            'id_banca',
            'id_banca');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function orgao()
    {
        return $this->hasOne('Orgao',
            'id_orgao',
            'id_orgao');
    }
}
