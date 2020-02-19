<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Assunto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_assunto', function (Blueprint $table) {
            $table->bigIncrements('id_assunto');

            $table->string('no_assunto', 100)
                ->unique();

            $table->unsignedBigInteger('id_assunto_pai', false)
                ->nullable();

            $table->foreign('id_assunto_pai', 'FK_ASSUNTO_PAI')
                ->references('id_assunto')
                ->on('tb_assunto');

            $table->unique(['no_assunto', 'id_assunto_pai']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_assunto');
    }
}
