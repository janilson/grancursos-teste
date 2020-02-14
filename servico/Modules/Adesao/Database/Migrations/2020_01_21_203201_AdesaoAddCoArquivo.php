<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdesaoAddCoArquivo extends Migration
{
    const CO_ARQUIVO = 'CO_ARQUIVO';
    const TB_ADESAO = 'TB_ADESAO';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn(self::TB_ADESAO, self::CO_ARQUIVO)) {
            Schema::table(self::TB_ADESAO, function (Blueprint $table) {
                $table->unsignedInteger(self::CO_ARQUIVO)
                    ->comment('CHAVE ESTRANGEIRA DA TABELA TB_ARQUIVO')
                    ->nullable();

                $table->foreign(self::CO_ARQUIVO, 'FK_ARQUIVO_ADESAO')
                    ->references(self::CO_ARQUIVO)
                    ->on('TB_ARQUIVO');
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
        if (Schema::hasColumn(self::TB_ADESAO, self::CO_ARQUIVO)) {
            Schema::table(self::TB_ADESAO, function (Blueprint $table) {
                $table->dropColumn('CO_ARQUIVO');
            });
        }
    }
}

