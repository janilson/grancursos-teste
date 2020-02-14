<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RespostaHistorico extends Migration
{
    const CO_RESPOSTA = 'CO_RESPOSTA';
    const CO_FORMULARIO_RESPOSTA = 'CO_FORMULARIO_RESPOSTA';
    const TH_RESPOSTA = 'TH_RESPOSTA';
    const CO_USUARIO = 'CO_USUARIO';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TH_RESPOSTA, function (Blueprint $table) {
            $table->bigIncrements(self::CO_RESPOSTA)
                ->autoIncrement()
                ->comment('CHAVE PRIMÁRIA DA TABELA ' . self::TH_RESPOSTA);

            $sequence = DB::getSequence();
            $sequence->create('SQ_RESPOSTA');

            $table->unsignedInteger(self::CO_FORMULARIO_RESPOSTA)
                ->comment('CHAVE ESTRANGEIRA DA TABELA TB_FORMULARIO_RESPOSTA');

            $table->foreign(self::CO_FORMULARIO_RESPOSTA, 'FK_FORMRESP_RESPOSTA')
                ->references(self::CO_FORMULARIO_RESPOSTA)
                ->on('TB_FORMULARIO_RESPOSTA');

            $table->unsignedInteger(self::CO_USUARIO)
                ->comment('CHAVE ESTRANGEIRA DA TABELA TB_USUARIO');

            $table->foreign(self::CO_USUARIO, 'FK_USUARIO_RESPOSTA')
                ->references(self::CO_USUARIO)
                ->on('TB_USUARIO');

            $table->char('ST_RESPOSTA', 1)
                ->default("0")
                ->comment('0 - PARA "FALSE" / 1 - PARA "VERDADEIRO" - INDICA SE A RESPOSTA ESTÁ MARCADA');

            $table->timestamp('DH_RESPOSTA')
                ->comment('DATA E HORA DA CRIAÇÃO DA RESPOSTA');
        });

        DB::unprepared('
        CREATE OR REPLACE TRIGGER DB_MAISCIDADAO.TG_RESPOSTA_SEQUENCE
            BEFORE INSERT ON DB_MAISCIDADAO.TH_RESPOSTA
            FOR EACH ROW
        BEGIN
            IF :NEW.CO_RESPOSTA IS NULL THEN
                SELECT SQ_RESPOSTA.nextval INTO :NEW.CO_RESPOSTA FROM DUAL;
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
        DB::unprepared('DROP TRIGGER DB_MAISCIDADAO.TG_RESPOSTA_SEQUENCE');
        $sequence = DB::getSequence();
        $sequence->drop('SQ_RESPOSTA');
        Schema::dropIfExists(self::TH_RESPOSTA);
    }
}