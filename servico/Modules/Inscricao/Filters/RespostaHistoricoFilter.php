<?php

namespace Modules\Inscricao\Filters;

use Illuminate\Database\Eloquent\Builder;
use Thalfm\LaravelEloquentFilter\Filters\SimpleQueryFilter;

/**
 * Class RespostaHistoricoFilter
 * @package Modules\Inscricao\Filters
 */
class RespostaHistoricoFilter extends SimpleQueryFilter
{
    const CO_FORMULARIO_RESPOSTA = 'co_formulario_resposta';
    const CO_FORMULARIO_ITEM_INSCRICAO = 'co_formulario_item_inscricao';
    const CO_GRUPO = 'co_grupo';
    const CO_USUARIO = 'co_usuario';

    const TB_FORMULARIO_ITEM_INSCRICAO = 'tb_formulario_item_inscricao';
    const TB_FORMULARIO_RESPOSTA = 'tb_formulario_resposta';
    const TB_GRUPO = 'tb_grupo';
    const TH_RESPOSTA = 'th_resposta';
    const TB_USUARIO = 'tb_usuario';

    /**
     * @param $query
     * @return Builder
     */
    public function apply($query)
    {
        $query
            ->select([
                'th_resposta.co_resposta',
                'th_resposta.co_usuario',
                'th_resposta.co_formulario_resposta',
                'th_resposta.dh_resposta',
                'th_resposta.st_resposta_antiga',
                'th_resposta.st_resposta_atual',
                'tb_formulario_item_inscricao.co_grupo',
                'tb_formulario_item_inscricao.ds_formulario_item_inscricao AS ds_item',
            ])
            ->join(self::TB_FORMULARIO_RESPOSTA,
                self::TB_FORMULARIO_RESPOSTA . '.' . self::CO_FORMULARIO_RESPOSTA,
                '=',
                self::TH_RESPOSTA . '.' . self::CO_FORMULARIO_RESPOSTA)
            ->join(self::TB_FORMULARIO_ITEM_INSCRICAO,
                self::TB_FORMULARIO_ITEM_INSCRICAO . '.' . self::CO_FORMULARIO_ITEM_INSCRICAO,
                '=',
                self::TB_FORMULARIO_RESPOSTA . '.' . self::CO_FORMULARIO_ITEM_INSCRICAO)
            ->join(self::TB_GRUPO,
                self::TB_GRUPO . '.' . self::CO_GRUPO,
                '=',
                self::TB_FORMULARIO_ITEM_INSCRICAO . '.' . self::CO_GRUPO)
            ->join(self::TB_USUARIO,
                self::TB_USUARIO . '.' . self::CO_USUARIO,
                '=',
                self::TH_RESPOSTA . '.' . self::CO_USUARIO);

        return parent::apply($query);
    }

    /**
     * @param $value
     * @throws \Exception
     */
    protected function applyDtResposta($value)
    {
        $dateTime = new \DateTime($value);
        $this->query->whereDate('th_resposta.dh_resposta', $dateTime->format('Y-m-d'));
    }

    /**
     * @param $value
     * @throws \Exception
     */
    protected function applyNoServidor($value)
    {
        $noUsuario = self::TB_USUARIO . '.no_usuario';
        $this->query->whereRaw("LOWER({$noUsuario}) LIKE ?", [mb_strtolower("%{$value}%")]);
    }

    /**
     * @param $value
     * @throws \Exception
     */
    protected function applyCoGrupo($value)
    {
        $this->query->where('tb_grupo.co_grupo', $value);
    }
}