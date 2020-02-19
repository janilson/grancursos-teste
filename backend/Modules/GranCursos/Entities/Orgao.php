<?php

namespace Modules\GranCursos\Entities;

use Illuminate\Database\Eloquent\Model;

class Orgao extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'id_orgao';
    protected $table = 'tb_orgao';

    protected $fillable = [
        'id_orgao',
        'no_orgao',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function questoes()
    {
        return $this->hasMany('Questao',
            'id_orgao',
            'id_orgao');
    }

}
