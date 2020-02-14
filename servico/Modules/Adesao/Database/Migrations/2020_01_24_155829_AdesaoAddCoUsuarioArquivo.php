<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdesaoAddCoUsuarioArquivo extends Migration
{
    const CO_USUARIO_ARQUIVO = 'CO_USUARIO_ARQUIVO';
    const TB_ADESAO = 'TB_ADESAO';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn(self::TB_ADESAO, self::CO_USUARIO_ARQUIVO)) {
            Schema::table(self::TB_ADESAO, function (Blueprint $table) {
                $table->unsignedInteger(self::CO_USUARIO_ARQUIVO)
                    ->comment('CHAVE ESTRANGEIRA DA TABELA TB_USUARIO')
                    ->nullable();

                $table->foreign(self::CO_USUARIO_ARQUIVO, 'FK_ADESAO_USUARIO')
                    ->references('CO_USUARIO')
                    ->on('TB_USUARIO');
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
        if (Schema::hasColumn(self::TB_ADESAO, self::CO_USUARIO_ARQUIVO)) {
            Schema::table(self::TB_ADESAO, function (Blueprint $table) {
                $table->dropColumn('CO_USUARIO_ARQUIVO');
            });
        }
    }

}