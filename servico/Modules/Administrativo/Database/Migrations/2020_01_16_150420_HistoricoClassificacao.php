<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HistoricoClassificacao extends Migration
{
    const CO_CLASSIFICACAO = 'CO_CLASSIFICACAO';
    const CO_ADESAO = 'CO_ADESAO';
    const TH_CLASSIFICACAO = 'TH_CLASSIFICACAO';
    const CO_USUARIO = 'CO_USUARIO';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TH_CLASSIFICACAO, function (Blueprint $table) {
            $table->bigIncrements(self::CO_CLASSIFICACAO)
                ->autoIncrement()
                ->comment('CHAVE PRIMÁRIA DA TABELA ' . self::TH_CLASSIFICACAO);

            $sequence = DB::getSequence();
            $sequence->create('SQ_CLASSIFICACAO');

            $table->unsignedInteger(self::CO_ADESAO)
                ->comment('CHAVE ESTRANGEIRA DA TABELA TB_ADESAO');

            $table->foreign(self::CO_ADESAO, 'FK_ADESAO_CLASSFICACAO')
                ->references(self::CO_ADESAO)
                ->on('TB_ADESAO');

            $table->unsignedInteger(self::CO_USUARIO)
                ->nullable(true)
                ->comment('CHAVE ESTRANGEIRA DA TABELA TB_USUARIO');

            $table->foreign(self::CO_USUARIO, 'FK_USUARIO_CLASSFICACAO')
                ->references(self::CO_USUARIO)
                ->on('TB_USUARIO');

            $table->decimal('NU_CLASSIFICACAO', 3, 0)
                ->comment('CLASSIFICAÇÂO DA ADESÃO');

            $table->decimal('NU_POSICAO', 3, 0)
                ->comment('POSIÇÃO DA ADESÃ DA ADESÃO');

            $table->decimal('NU_PONTUACAO_FINAL', 2, 0)
                ->comment('PONTUAÇÃO FINAL DA ADESÃO');

            $table->char('ST_CLASSIFICACAO', 1)
                ->default("T")
                ->comment('T - PARA "TEMPORÁRIO" / F - PARA "FINAL" - INDICA SE A CLASSIFICAÇÃO É TEMPORÁRIA OU FINAL');

            $table->timestamp('DH_CLASSIFICACAO')
                ->comment('DATA E HORA DA CLASSIFICAÇÃO');
        });

        DB::unprepared('
        CREATE OR REPLACE TRIGGER DB_MAISCIDADAO.TG_CLASSFICACAO_SEQUENCE
            BEFORE INSERT ON DB_MAISCIDADAO.TH_CLASSIFICACAO
            FOR EACH ROW
        BEGIN
            IF :NEW.CO_CLASSIFICACAO IS NULL THEN
                SELECT SQ_CLASSIFICACAO.nextval INTO :NEW.CO_CLASSIFICACAO FROM DUAL;
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
        DB::unprepared('DROP TRIGGER DB_MAISCIDADAO.TG_CLASSFICACAO_SEQUENCE');
        $sequence = DB::getSequence();
        $sequence->drop('SQ_CLASSIFICACAO');
        Schema::dropIfExists(self::TH_CLASSIFICACAO);
    }
}
