<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InscricaoEnvioAddNuPontuacaoAtual extends Migration
{
    const NU_PONTUACAO_ATUAL = 'NU_PONTUACAO_ATUAL';
    const TB_INSCRICAO_ENVIO = 'TB_INSCRICAO_ENVIO';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn(self::TB_INSCRICAO_ENVIO, self::NU_PONTUACAO_ATUAL)) {
            Schema::table(self::TB_INSCRICAO_ENVIO, function (Blueprint $table) {
                $table->decimal(self::NU_PONTUACAO_ATUAL, 2 , 0)
                    ->comment('VALOR DA PONTUAÇÃO ATUAL NO ENVIO DA INSCRIÇÃO.');
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
        if (Schema::hasColumn(self::TB_INSCRICAO_ENVIO, self::NU_PONTUACAO_ATUAL)) {
            Schema::table(self::TB_INSCRICAO_ENVIO, function (Blueprint $table) {
                $table->dropColumn(self::NU_PONTUACAO_ATUAL);
            });
        }
    }
}
