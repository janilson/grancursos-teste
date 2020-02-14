<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdesaoTable extends Migration
{
    const CO_MUNICIPIO = 'CO_MUNICIPIO';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TB_ADESAO', function (Blueprint $table) {
            $table->bigIncrements('CO_ADESAO')
                ->primary()
                ->autoIncrement()
                ->comment('CHAVE PRIMÁRIA DA TABELA tb_adesao');

            $sequence = DB::getSequence();
            $sequence->create('SQ_ADESAO');

            $table->decimal('CO_MUNICIPIO', 9, 0)
                ->comment('CÓDIGO DO MUNICÍPIO AO QUAL O REPRESENTANTE ESTA VINCULADO');

            $table->foreign(self::CO_MUNICIPIO, 'FK_MUNICIPIO_ADESAO')
                ->references(self::CO_MUNICIPIO)
                ->on('TB_MUNICIPIO');

            $table->string('NO_PREFEITO', 200)
                ->comment('NOME DO PREFEITO DO MUNICÍPIO');

            $table->timestamp('DH_CADASTRO')
                ->comment('DATA E HORA DA CRIAÇÃO DO CADASTRO NA ADESÃO');
        });

        DB::unprepared('
        CREATE OR REPLACE TRIGGER DB_MAISCIDADAO.TG_ADESAO_SEQUENCE
            BEFORE INSERT ON DB_MAISCIDADAO.TB_ADESAO
            FOR EACH ROW
        BEGIN
            IF :NEW.CO_ADESAO IS NULL THEN
                SELECT SQ_ADESAO.nextval INTO :new.CO_ADESAO FROM DUAL;
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
        DB::unprepared('DROP TRIGGER DB_MAISCIDADAO.TG_ADESAO_SEQUENCE');
        $sequence = DB::getSequence();
        $sequence->drop('SQ_ADESAO');
        Schema::dropIfExists('TB_ADESAO');
    }
}
