<?php

namespace Modules\GranCursos\Entities;

use Illuminate\Database\Eloquent\Model;

class Assunto extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'id_assunto';
    protected $table = 'tb_assunto';

    protected $fillable = [
        'id_assunto',
        'no_assunto',
        'id_assunto_pai',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questoes()
    {
        return $this->hasMany('Questao',
            'id_assunto',
            'id_assunto');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function filhos()
    {
        return $this->hasMany('Assunto',
            'id_assunto',
            'id_assunto_pai');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function pai()
    {
        return $this->hasOne('Assunto',
            'id_assunto_pai',
            'id_assunto');
    }
}
