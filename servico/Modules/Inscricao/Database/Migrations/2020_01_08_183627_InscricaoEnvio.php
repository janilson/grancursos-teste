<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InscricaoEnvio extends Migration
{
    const CO_INSCRICAO_ENVIO = 'CO_INSCRICAO_ENVIO';
    const CO_ADESAO = 'CO_ADESAO';
    const TB_INSCRICAO_ENVIO = 'TB_INSCRICAO_ENVIO';
    const CO_USUARIO_ENVIO = 'CO_USUARIO_ENVIO';
    const CO_USUARIO = 'CO_USUARIO';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TB_INSCRICAO_ENVIO, function (Blueprint $table) {
            $table->bigIncrements(self::CO_INSCRICAO_ENVIO)
                ->autoIncrement()
                ->comment('CHAVE PRIMÁRIA DA TABELA ' . self::TB_INSCRICAO_ENVIO);

            $sequence = DB::getSequence();
            $sequence->create('SQ_INSCRICAO_ENVIO');

            $table->unsignedInteger(self::CO_ADESAO)
                ->comment('CHAVE ESTRANGEIRA DA TABELA TB_ADESAO');

            $table->foreign(self::CO_ADESAO, 'FK_ADESAO_INSCRICAOENVIO')
                ->references(self::CO_ADESAO)
                ->on('TB_ADESAO');

            $table->unsignedInteger(self::CO_USUARIO_ENVIO)
                ->comment('CHAVE ESTRANGEIRA DA TABELA TB_USUARIO');

            $table->foreign(self::CO_USUARIO_ENVIO, 'FK_USUARIO_INSCRICAOENVIO')
                ->references(self::CO_USUARIO)
                ->on('TB_USUARIO');

            $table->jsonb('DS_ENVIO')
                ->comment('JSON COM TODAS AS RESPOSTAS NO MOMENTO DO ENVIO DA INSCRIÇÃO');

            $table->string('DS_CAMINHO_ARQUIVO', 200)
                ->comment('CAMINHO DO ARQUIVO GERADO COM TODAS AS RESPOSTAS NO MOMENTO DO ENVIO DA INSCRIÇÃO');

            $table->timestamp('DH_ENVIO')
                ->comment('DATA E HORA DO ENVIO DA INSCRIÇÃO');
        });

        DB::unprepared('
        CREATE OR REPLACE TRIGGER DB_MAISCIDADAO.TG_INSCRICAOENVIO_SEQUENCE
            BEFORE INSERT ON DB_MAISCIDADAO.TB_INSCRICAO_ENVIO
            FOR EACH ROW
        BEGIN
            IF :NEW.CO_INSCRICAO_ENVIO IS NULL THEN
                SELECT SQ_INSCRICAO_ENVIO.nextval INTO :NEW.CO_INSCRICAO_ENVIO FROM DUAL;
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
        DB::unprepared('DROP TRIGGER DB_MAISCIDADAO.TG_INSCRICAOENVIO_SEQUENCE');
        $sequence = DB::getSequence();
        $sequence->drop('SQ_INSCRICAO_ENVIO');
        Schema::dropIfExists(self::TB_INSCRICAO_ENVIO);
    }
}
