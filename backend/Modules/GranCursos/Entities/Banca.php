<?php

namespace Modules\GranCursos\Entities;

use Illuminate\Database\Eloquent\Model;

class Banca extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'id_banca';
    protected $table = 'tb_banca';

    protected $fillable = [
        'id_banca',
        'no_banca',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questoes()
    {
        return $this->hasMany('Questao',
            'id_banca',
            'id_banca');
    }
}
