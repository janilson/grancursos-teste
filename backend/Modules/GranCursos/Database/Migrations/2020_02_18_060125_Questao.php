<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Questao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_questao', function (Blueprint $table) {
            $table->bigIncrements('id_questao');

            $table->string('no_questao', 100)
                ->unique();

            $table->unsignedBigInteger('id_assunto', false);

            $table->foreign('id_assunto', 'FK_ASSUNTO')
                ->references('id_assunto')
                ->on('tb_assunto');

            $table->unsignedBigInteger('id_banca', false);

            $table->foreign('id_banca', 'FK_BANCA')
                ->references('id_banca')
                ->on('tb_banca');

            $table->unsignedBigInteger('id_orgao', false);

            $table->foreign('id_orgao', 'FK_ORGAO')
                ->references('id_orgao')
                ->on('tb_orgao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_questao');
    }
}
