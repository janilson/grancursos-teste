<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Arquivo extends Migration
{
    const CO_ARQUIVO = 'CO_ARQUIVO';
    const TB_ARQUIVO = 'TB_ARQUIVO';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TB_ARQUIVO, function (Blueprint $table) {
            $table->bigIncrements(self::CO_ARQUIVO)
                ->autoIncrement()
                ->comment('CHAVE PRIMÁRIA DA TABELA ' . self::TB_ARQUIVO);

            $sequence = DB::getSequence();
            $sequence->create('SQ_ARQUIVO');

            $table->string('NO_ARQUIVO', 200)
                ->comment('NOME DO ARQUIVO');

            $table->string('DS_CAMINHO_ARQUIVO', 200)
                ->comment('PATH DO ARQUIVO');

            $table->string('NO_EXTENSAO', 200)
                ->comment('EXTENSÃO DO ARQUIVO');

            $table->string('NO_MIME_TYPE', 50)
                ->comment('MIME TYPE DO ARQUIVO');

            $table->timestamp('DH_ARQUIVO')
                ->comment('DATA E HORA DA CRIAÇÃO DO ARQUIVO');
        });

        DB::unprepared('
        CREATE OR REPLACE TRIGGER DB_MAISCIDADAO.TG_ARQUIVO_SEQUENCE
            BEFORE INSERT ON DB_MAISCIDADAO.TB_ARQUIVO
            FOR EACH ROW
        BEGIN
            IF :NEW.CO_ARQUIVO IS NULL THEN
                SELECT SQ_ARQUIVO.nextval INTO :NEW.CO_ARQUIVO FROM DUAL;
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
        DB::unprepared('DROP TRIGGER DB_MAISCIDADAO.TG_ARQUIVO_SEQUENCE');
        $sequence = DB::getSequence();
        $sequence->drop('SQ_ARQUIVO');
        Schema::dropIfExists(self::TB_ARQUIVO);
    }
}