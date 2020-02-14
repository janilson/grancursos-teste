<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Uf extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TB_UF', function (Blueprint $table) {
            $table->decimal('CO_UF', 2, 0)
                ->primary()
                ->autoIncrement()
                ->comment('CHAVE PRIMÁRIA DA TABELA TB_UF');

            $sequence = DB::getSequence();
            $sequence->create('SQ_UF');

            $table->string('NO_UF')
                ->comment('NOME DO ESTADO BRASILEIRO.');

            $table->char('SG_UF', 2)
                ->comment('SIGLA DO ESTADO BRASILEIRO.');
        });

        DB::unprepared('
        CREATE OR REPLACE TRIGGER DB_MAISCIDADAO.TG_UF_SEQUENCE
            BEFORE INSERT ON DB_MAISCIDADAO.TB_UF
            FOR EACH ROW
        BEGIN
            IF :NEW.CO_UF IS NULL THEN
                SELECT SQ_UF.nextval INTO :NEW.CO_UF FROM DUAL;
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
        DB::unprepared('DROP TRIGGER DB_MAISCIDADAO.TG_UF_SEQUENCE');
        $sequence = DB::getSequence();
        $sequence->drop('SQ_UF');
        Schema::dropIfExists('TB_UF');
    }
}
