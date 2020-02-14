<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ItemInscricaoRemoveTpComponente extends Migration
{
    const TP_COMPONENTE = 'TP_COMPONENTE';
    const TB_FORMULARIO_ITEM_INSCRICAO = 'TB_FORMULARIO_ITEM_INSCRICAO';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn(self::TB_FORMULARIO_ITEM_INSCRICAO, self::TP_COMPONENTE)) {
            Schema::table(self::TB_FORMULARIO_ITEM_INSCRICAO, function (Blueprint $table) {
                $table->dropColumn(self::TP_COMPONENTE);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!Schema::hasColumn(self::TB_FORMULARIO_ITEM_INSCRICAO, self::TP_COMPONENTE)) {
            Schema::table(self::TB_FORMULARIO_ITEM_INSCRICAO, function (Blueprint $table) {
                $table->char('TP_COMPONENTE', 1)
                    ->default("C")
                    ->comment('C - PARA "CHECKBOX" / R - PARA "RADIO" - INDICA SE O ITEM DE GRUPO É TIPO CHECKBOX OU RADIO');
            });
        }
    }
}
