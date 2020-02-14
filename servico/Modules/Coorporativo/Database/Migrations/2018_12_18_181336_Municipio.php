<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Municipio extends Migration
{
    const CO_UF = 'CO_UF';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TB_MUNICIPIO', function (Blueprint $table) {
            $table->decimal('CO_MUNICIPIO', 9, 0)
                ->autoIncrement()
                ->primary()
                ->comment('CHAVE PRIMÁRIA DA TABELA TB_MUNICIPIO');

            $sequence = DB::getSequence();
            $sequence->create('SQ_MUNICIPIO');

            $table->unsignedInteger(self::CO_UF)
                ->comment('CHAVE ESTRANGEIRA DA TABELA TB_UF');

            $table->foreign(self::CO_UF, 'FK_UF_MUNICIPIO')
                ->references(self::CO_UF)
                ->on('TB_UF');

            $table->string('NO_MUNICIPIO', 100)
                ->comment('NOME DO MUNICÍPIO.');

            $table->decimal('CO_IBGE', 7, 0)
                ->comment('CÓDIGO COM 7 DIGITOS ORIUNDO DO INSTITUTO BRASILEIRO DE GEOGRAFIA E ESTATÍSTICA - IBGE, UMA ORGANIZAÇÃO PÚBLICA RESPONSÁVEL PELOS LEVANTAMENTOS E GERENCIAMENTOS DOS DADOS E ESTATÍSTICAS BRASILEIRAS.');
        });

        DB::unprepared('
        CREATE OR REPLACE TRIGGER DB_MAISCIDADAO.TG_MUNICIPIO_SEQUENCE
            BEFORE INSERT ON DB_MAISCIDADAO.TB_MUNICIPIO
            FOR EACH ROW
        BEGIN
            IF :NEW.CO_MUNICIPIO IS NULL THEN
                SELECT SQ_MUNICIPIO.nextval INTO :NEW.CO_MUNICIPIO FROM DUAL;
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
        DB::unprepared('DROP TRIGGER DB_MAISCIDADAO.TG_MUNICIPIO_SEQUENCE');
        $sequence = DB::getSequence();
        $sequence->drop('SQ_MUNICIPIO');
        Schema::dropIfExists('TB_MUNICIPIO');
    }
}
