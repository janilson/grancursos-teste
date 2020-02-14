<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FormularioResposta extends Migration
{
    const CO_FORMULARIO_ITEM_INSCRICAO = 'CO_FORMULARIO_ITEM_INSCRICAO';
    const CO_ADESAO = 'CO_ADESAO';
    const CO_USUARIO_CADASTRO = 'CO_USUARIO_CADASTRO';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TB_FORMULARIO_RESPOSTA', function (Blueprint $table) {
            $table->bigIncrements('CO_FORMULARIO_RESPOSTA')
                ->autoIncrement()
                ->comment('CHAVE PRIMÁRIA DA TABELA TB_FORMULARIO_RESPOSTA');

            $sequence = DB::getSequence();
            $sequence->create('SQ_FORMULARIO_RESPOSTA');

            $table->unsignedInteger(self::CO_FORMULARIO_ITEM_INSCRICAO)
                ->comment('CHAVE ESTRANGEIRA DA TABELA TB_FORMULARIO_ITEM_INSCRICAO');

            $table->foreign(self::CO_FORMULARIO_ITEM_INSCRICAO, 'FK_FORMITEMINSC_FORMRESPOSTA')
                ->references(self::CO_FORMULARIO_ITEM_INSCRICAO)
                ->on('TB_FORMULARIO_ITEM_INSCRICAO');

            $table->unsignedInteger(self::CO_ADESAO)
                ->comment('CHAVE ESTRANGEIRA DA TABELA TB_ADESAO');

            $table->foreign(self::CO_ADESAO, 'FK_ADESAO_FORMULARIORESPOSTA')
                ->references(self::CO_ADESAO)
                ->on('TB_ADESAO');

            $table->unsignedInteger(self::CO_USUARIO_CADASTRO)
                ->comment('CHAVE ESTRANGEIRA DA TABELA TB_USUARIO');

            $table->foreign(self::CO_USUARIO_CADASTRO, 'FK_USUARIO_FORMULARIORESPOSTA')
                ->references('CO_USUARIO')
                ->on('TB_USUARIO');

            $table->char('ST_RESPOSTA', 1)
                ->default("0")
                ->comment('0 - PARA "FALSE" / 1 - PARA "VERDADEIRO" - INDICA SE A RESPOSTA ESTÁ MARCADA');

            $table->char('ST_ENVIADO', 1)
                ->default("N")
                ->comment('N - PARA "NÂO" / S - PARA "SIM" - INDICA SE A RESPOSTA FOI ENVIADA PARA OS USUÁRIOS');

            $table->timestamp('DH_RESPOSTA')
                ->comment('DATA E HORA DA CRIAÇÃO DA RESPOSTA');
        });

        DB::unprepared('
        CREATE OR REPLACE TRIGGER DB_MAISCIDADAO.TG_FORMRESPOSTA_SEQUENCE
            BEFORE INSERT ON DB_MAISCIDADAO.TB_FORMULARIO_RESPOSTA
            FOR EACH ROW
        BEGIN
            IF :NEW.CO_FORMULARIO_RESPOSTA IS NULL THEN
                SELECT SQ_FORMULARIO_RESPOSTA.nextval INTO :NEW.CO_FORMULARIO_RESPOSTA FROM DUAL;
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
        DB::unprepared('DROP TRIGGER DB_MAISCIDADAO.TG_FORMRESPOSTA_SEQUENCE');
        $sequence = DB::getSequence();
        $sequence->drop('SQ_FORMULARIO_RESPOSTA');
        Schema::dropIfExists('TB_FORMULARIO_RESPOSTA');
    }
}