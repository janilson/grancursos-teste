<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Grupo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TB_GRUPO', function (Blueprint $table) {
            $table->decimal('CO_GRUPO', 2 , 0)
                ->primary()
                ->autoIncrement()
                ->comment('CHAVE PRIMÁRIA DA TABELA TB_GRUPO');

            $sequence = DB::getSequence();
            $sequence->create('SQ_GRUPO');

            $table->string('DS_GRUPO', 200)
                ->comment('DESCRIÇÃO DO GRUPO');
        });

        DB::unprepared('
        CREATE OR REPLACE TRIGGER DB_MAISCIDADAO.TG_GRUPO_SEQUENCE
            BEFORE INSERT ON DB_MAISCIDADAO.TB_GRUPO
            FOR EACH ROW
        BEGIN
            IF :NEW.CO_GRUPO IS NULL THEN
                SELECT SQ_GRUPO.nextval INTO :NEW.CO_GRUPO FROM DUAL;
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
        DB::unprepared('DROP TRIGGER DB_MAISCIDADAO.TG_GRUPO_SEQUENCE');
        $sequence = DB::getSequence();
        $sequence->drop('SQ_GRUPO');
        Schema::dropIfExists('TB_GRUPO');
    }
}
