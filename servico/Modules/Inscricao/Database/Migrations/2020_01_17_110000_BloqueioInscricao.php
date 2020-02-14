<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BloqueioInscricao extends Migration
{
    const TB_BLOQUEIO_INSCRICAO = 'TB_BLOQUEIO_INSCRICAO';
    const CO_BLOQUEIO_INSCRICAO = 'CO_BLOQUEIO_INSCRICAO';
    const CO_ADESAO = 'CO_ADESAO';
    const CO_USUARIO = 'CO_USUARIO';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TB_BLOQUEIO_INSCRICAO, function (Blueprint $table) {

            $table->bigIncrements(self::CO_BLOQUEIO_INSCRICAO)
                ->autoIncrement()
                ->comment('CHAVE PRIMÁRIA DA TABELA ' . self::TB_BLOQUEIO_INSCRICAO);

            $sequence = DB::getSequence();
            $sequence->create('SQ_BLOQUEIO_INSCRICAO');

            $table->unsignedInteger(self::CO_ADESAO)
                ->comment('CHAVE ESTRANGEIRA DA TABELA TB_ADESAO');

            $table->foreign(self::CO_ADESAO, 'FK_ADESAO_BLOQUEIOINSCRICAO')
                ->references(self::CO_ADESAO)
                ->on('TB_ADESAO');

            $table->unsignedInteger(self::CO_USUARIO)
                ->comment('CHAVE ESTRANGEIRA DA TABELA TB_USUARIO');

            $table->foreign(self::CO_USUARIO, 'FK_USUARIO_BLOQUEIOINSCRICAO')
                ->references(self::CO_USUARIO)
                ->on('TB_USUARIO');

            $table->char('ST_BLOQUEIO', 1)
                ->default('B')
                ->comment('SITUAÇÃO DO BLOQUEIO DA INSCRIÇÃO - B = BLOQUEADO, D = DESBLOQUEADO');

            $table->timestamp('DH_BLOQUEIO')
                ->comment('DATA E HORA DO BLOQUEIO DA INSCRIÇÃO');

        });

        DB::unprepared('
        CREATE OR REPLACE TRIGGER DB_MAISCIDADAO.TG_BLOQUEIOINSCRICAO_SEQUENCE
            BEFORE INSERT ON DB_MAISCIDADAO.TB_BLOQUEIO_INSCRICAO
            FOR EACH ROW
        BEGIN
            IF :NEW.CO_BLOQUEIO_INSCRICAO IS NULL THEN
                SELECT SQ_BLOQUEIO_INSCRICAO.nextval INTO :NEW.CO_BLOQUEIO_INSCRICAO FROM DUAL;
            END IF;
        END;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER DB_MAISCIDADAO.TG_BLOQUEIOINSCRICAO_SEQUENCE');
        $sequence = DB::getSequence();
        $sequence->drop('SQ_BLOQUEIO_INSCRICAO');
        Schema::dropIfExists(self::TB_BLOQUEIO_INSCRICAO);
    }
}
