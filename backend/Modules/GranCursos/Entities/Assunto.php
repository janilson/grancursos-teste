<?php

namespace Modules\GranCursos\Entities;

use Illuminate\Database\Eloquent\Model;
use Thalfm\LaravelEloquentFilter\Traits\Filterable;
use Staudenmeir\LaravelCte\Eloquent\QueriesExpressions;

class Assunto extends Model
{
    use Filterable;
    use QueriesExpressions;

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
        return $this->hasMany(Questao::class,
            'id_assunto',
            'id_assunto');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function filhos()
    {
        return $this->hasMany(Assunto::class,
            'id_assunto_pai',
            'id_assunto');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function pai()
    {
        return $this->hasOne(Assunto::class,
            'id_assunto',
            'id_assunto_pai');
    }
}
