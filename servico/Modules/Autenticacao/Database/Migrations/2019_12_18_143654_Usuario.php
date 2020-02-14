<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Usuario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TB_USUARIO', function (Blueprint $table) {
            $table->bigIncrements('CO_USUARIO')
                ->primary()
                ->autoIncrement()
                ->comment('CHAVE PRIMÁRIA DA TABELA TB_USUARIO');

            $sequence = DB::getSequence();
            $sequence->create('SQ_USUARIO');

            $table->string('NO_USUARIO', 200)
                ->comment('NOME DO USUÁRIO');

            $table->string('NU_CPF', 11)
                ->comment('CPF DO USUÁRIO');

            $table->string('DS_EMAIL', 100)
                ->comment('EMAIL DO USUÁRIO');

            $table->string('DS_SENHA', 60)
                ->comment('CPF DO USUÁRIO');

            $table->char('TP_PERFIL', 1)
                ->default("E")
                ->comment('E - PARA "EXTERNO" / I - PARA "INTERNO" - INDICA SE O USUÁRIO É INTERNO OU EXTERNO');
        });

        DB::unprepared('
        CREATE OR REPLACE TRIGGER DB_MAISCIDADAO.TG_USUARIO_SEQUENCE
            BEFORE INSERT ON DB_MAISCIDADAO.TB_USUARIO
            FOR EACH ROW
        BEGIN
            IF :NEW.CO_USUARIO IS NULL THEN
                SELECT SQ_USUARIO.nextval INTO :NEW.CO_USUARIO FROM DUAL;
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
        DB::unprepared('DROP TRIGGER DB_MAISCIDADAO.TG_USUARIO_SEQUENCE');
        $sequence = DB::getSequence();
        $sequence->drop('SQ_USUARIO');
        Schema::dropIfExists('TB_USUARIO');
    }
}
