<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RespostaHistoricoAddStRespostaAntiga extends Migration
{
    const ST_RESPOSTA_ANTIGA = 'ST_RESPOSTA_ANTIGA';
    const TH_RESPOSTA = 'TH_RESPOSTA';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn(self::TH_RESPOSTA, self::ST_RESPOSTA_ANTIGA)) {
            Schema::table(self::TH_RESPOSTA, function (Blueprint $table) {
                $table->dropColumn('ST_RESPOSTA');

                $table->char('ST_RESPOSTA_ANTIGA', 1)
                    ->default("0")
                    ->comment('0 - PARA "FALSE" / 1 - PARA "VERDADEIRO" - INDICA SE A RESPOSTA ANTIGA ESTÁ MARCADA');

                $table->char('ST_RESPOSTA_ATUAL', 1)
                    ->default("0")
                    ->comment('0 - PARA "FALSE" / 1 - PARA "VERDADEIRO" - INDICA SE A RESPOSTA ATUAL ESTÁ MARCADA');
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
        if (Schema::hasColumn(self::TH_RESPOSTA, self::ST_RESPOSTA_ANTIGA)) {
            Schema::table(self::TH_RESPOSTA, function (Blueprint $table) {
                $table->dropColumn('ST_RESPOSTA_ANTIGA');

                $table->dropColumn('ST_RESPOSTA_ATUAL');

                $table->char('ST_RESPOSTA', 1)
                    ->default("0")
                    ->comment('0 - PARA "FALSE" / 1 - PARA "VERDADEIRO" - INDICA SE A RESPOSTA ESTÁ MARCADA');
            });
        }
    }
}
