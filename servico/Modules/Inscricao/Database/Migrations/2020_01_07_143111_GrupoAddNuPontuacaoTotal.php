<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GrupoAddNuPontuacaoTotal extends Migration
{
    const TB_GRUPO = 'TB_GRUPO';
    const NU_PONTUACAO_TOTAL = 'nu_pontuacao_total';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn(self::TB_GRUPO, self::NU_PONTUACAO_TOTAL)) {
            Schema::table(self::TB_GRUPO, function (Blueprint $table) {
                $table->decimal('NU_PONTUACAO_TOTAL', 2, 0)
                    ->default(0)
                    ->comment('PONTUAÇÃO TOTAL DO GRUPO');
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
        if (Schema::hasColumn(self::TB_GRUPO, self::NU_PONTUACAO_TOTAL)) {
            Schema::table(self::TB_GRUPO, function (Blueprint $table) {
                $table->dropColumn('NU_PONTUACAO_TOTAL');
            });
        }
    }
}
