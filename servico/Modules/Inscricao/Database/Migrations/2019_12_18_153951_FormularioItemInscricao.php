<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FormularioItemInscricao extends Migration
{
    const CO_GRUPO = 'CO_GRUPO';
    const CO_FORMULARIO_ITEM_INSC_PAI = 'CO_FORMULARIO_ITEM_INSC_PAI';
    const TB_FORMULARIO_ITEM_INSCRICAO = 'TB_FORMULARIO_ITEM_INSCRICAO';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TB_FORMULARIO_ITEM_INSCRICAO, function (Blueprint $table) {
            $table->bigIncrements('CO_FORMULARIO_ITEM_INSCRICAO')
                ->autoIncrement()
                ->comment('CHAVE PRIMÁRIA DA TABELA TB_FORMULARIO_ITEM_INSCRICAO');

            $sequence = DB::getSequence();
            $sequence->create('SQ_FORMULARIO_ITEM_INSCRICAO');

            $table->decimal(self::CO_GRUPO, 19, 0)
                ->comment('CHAVE ESTRANGEIRA DA TABELA TB_ADESAO');

            $table->foreign(self::CO_GRUPO, 'FK_GRUPO_FORMULARIOITEMINSC')
                ->references(self::CO_GRUPO)
                ->on('TB_GRUPO');

            $table->string('DS_FORMULARIO_ITEM_INSCRICAO', 400)
                ->comment('DESCRIÇÃO DO ITEM DE GRUPO');

            $table->unsignedInteger('NU_PONTUACAO')
                ->comment('VALOR DA PONTUAÇÃO DO ITEM DE GRUPO');

            $table->decimal(self::CO_FORMULARIO_ITEM_INSC_PAI, 19, 0)
                ->nullable(true)
                ->comment('CHAVE ESTRANGEIRA DA TABELA TB_FORMULARIO_ITEM_INSCRICAO');

            $table->foreign(self::CO_FORMULARIO_ITEM_INSC_PAI, 'FK_PAI_FORMULARIOITEMINSC')
                ->references('CO_FORMULARIO_ITEM_INSCRICAO')
                ->on(self::TB_FORMULARIO_ITEM_INSCRICAO);

            $table->char('TP_FORMULARIO_ITEM_INSCRICAO', 1)
                ->default("R")
                ->comment('R - PARA "RESPOSTA" / P - PARA "PERGUNTA" - INDICA SE O ITEM DE GRUPO É UMA PERGUNTA OU RESPOSTA');

            $table->char('TP_COMPONENTE', 1)
                ->default("C")
                ->comment('C - PARA "CHECKBOX" / R - PARA "RADIO" - INDICA SE O ITEM DE GRUPO É TIPO CHECKBOX OU RADIO');

            $table->unsignedInteger('NU_ORDEM')
                ->comment('ORDEM DE EXIBIÇÃO DO ITEM DE GRUPO');
        });

        DB::unprepared('
        CREATE OR REPLACE TRIGGER DB_MAISCIDADAO.TG_FORMITEMINSCR_SEQUENCE
            BEFORE INSERT ON DB_MAISCIDADAO.TB_FORMULARIO_ITEM_INSCRICAO
            FOR EACH ROW
        BEGIN
            IF :NEW.CO_FORMULARIO_ITEM_INSCRICAO IS NULL THEN
                SELECT SQ_FORMULARIO_ITEM_INSCRICAO.nextval INTO :NEW.CO_FORMULARIO_ITEM_INSCRICAO FROM DUAL;
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
        DB::unprepared('DROP TRIGGER DB_MAISCIDADAO.TG_FORMITEMINSCR_SEQUENCE');
        $sequence = DB::getSequence();
        $sequence->drop('SQ_FORMULARIO_ITEM_INSCRICAO');
        Schema::dropIfExists(self::TB_FORMULARIO_ITEM_INSCRICAO);
    }
}
