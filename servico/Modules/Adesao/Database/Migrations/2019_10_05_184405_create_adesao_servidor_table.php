<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdesaoServidorTable extends Migration
{

    const CO_ADESAO = 'co_adesao';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TB_ADESAO_SERVIDOR', function (Blueprint $table) {
            $table->bigIncrements('CO_ADESAO_SERVIDOR')
                ->autoIncrement()
                ->comment('CHAVE PRIMÁRIA DA TABELA TB_ADESAO_SERVIDOR');

            $sequence = DB::getSequence();
            $sequence->create('SQ_ADESAO_SERVIDOR');

            $table->unsignedInteger(self::CO_ADESAO)
                ->comment('CHAVE ESTRANGEIRA DA TABELA TB_ADESAO');

            $table->foreign(self::CO_ADESAO, 'FK_ADESAO_ADESAOSERVIDOR')
                ->references(self::CO_ADESAO)
                ->on('TB_ADESAO');

            $table->string('NU_CPF', 11)
                ->comment('NÚMERO DO CPF DO SERVIDOR');

            $table->string('NO_SERVIDOR', 200)
                ->comment('NOME DO SERVIDOR DA ADESÃO');

            $table->string('DS_EMAIL', 100)
                ->comment('E-MAIL DO SERVIDOR');

            $table->string('NU_TELEFONE', 11)
                ->comment('NÚMERO DO TELEFONE DO SERVIDOR DO REPRESENTANTE');

            $table->string('NO_FUNCAO', 100)
                ->comment('FUNÇÃO DO SERVIDOR');

            $table->string('NO_LOTACAO', 100)
                ->comment('LOTAÇÃO À QUAL O SERVIDOR SE ENCONTRA');

            $table->char('ST_COORDENADOR', 1)
                ->comment('S - PARA "SIM" / N - PARA "NÃO" - INDICA SE O SERVIDOR É COORDENADOR');
        });

        DB::unprepared('
        CREATE OR REPLACE TRIGGER DB_MAISCIDADAO.TG_ADESAO_SERVIDOR_SEQUENCE
            BEFORE INSERT ON DB_MAISCIDADAO.TB_ADESAO_SERVIDOR
            FOR EACH ROW
        BEGIN
            IF :NEW.CO_ADESAO_SERVIDOR IS NULL THEN
                SELECT SQ_ADESAO_SERVIDOR.nextval INTO :NEW.CO_ADESAO_SERVIDOR FROM DUAL;
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
        DB::unprepared('DROP TRIGGER DB_MAISCIDADAO.TG_ADESAO_SERVIDOR_SEQUENCE');
        $sequence = DB::getSequence();
        $sequence->drop('SQ_ADESAO_SERVIDOR');
        Schema::dropIfExists('TB_ADESAO_SERVIDOR');
    }
}
