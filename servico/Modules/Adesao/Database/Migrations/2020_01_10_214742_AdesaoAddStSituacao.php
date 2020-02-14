<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdesaoAddStSituacao extends Migration
{
    const ST_ENVIO = 'ST_ENVIO';
    const TB_ADESAO = 'TB_ADESAO';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn(self::TB_ADESAO, self::ST_ENVIO)) {
            Schema::table(self::TB_ADESAO, function (Blueprint $table) {
                $table->char('ST_ENVIO', 1)
                    ->default('A')
                    ->comment('A - PARA "AGUARDANDO PRÉ-REQUISITOS" / P - PARA "PENDENTE" / E - PARA "ENVIADO" - INDICA SE A ADESÃO FOI ENVIADA');
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
        if (Schema::hasColumn(self::TB_ADESAO, self::ST_ENVIO)) {
            Schema::table(self::TB_ADESAO, function (Blueprint $table) {
                $table->dropColumn('ST_ENVIO');
            });
        }
    }
}
