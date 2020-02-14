<?php

namespace Modules\Inscricao\Services;

use Carbon\Carbon;
use Modules\Inscricao\Entities\BloqueioInscricao;

/**
 * Class BloqueiooService
 * @package Modules\Inscricao\Services
 */
class BloqueioInscricaoService
{
    public static function verificarBloqueio()
    {
        $listaBloqueios = BloqueioInscricao::where(['st_bloqueio' => 'B'])->get();
        $agora = Carbon::now();

        $count = 0;
        foreach($listaBloqueios as $bloqueio) {
            $date = new \DateTime($bloqueio->dh_bloqueio);
            $interval = new \DateInterval('PT'. env('DESBLOQUEIO_MINUTOS', 30) . 'M');
            $horaExpiracao = $date->add($interval);

            if ($agora > $horaExpiracao) {
                $bloqueio->st_bloqueio = 'D';
                $bloqueio->save();
                $count++;
            }
        }

        return $count;
    }
}