<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MunicipioNuPopulacao extends Migration
{
    const TB_MUNICIPIO = 'TB_MUNICIPIO';
    const TP_GRUPO_MUNICIPIO = 'TP_GRUPO_MUNICIPIO';
    const NU_POPULACAO = 'NU_POPULACAO';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn(self::TB_MUNICIPIO, self::TP_GRUPO_MUNICIPIO)) {
            Schema::table(self::TB_MUNICIPIO, function (Blueprint $table) {
                $table->char(self::TP_GRUPO_MUNICIPIO, 1)
                    ->default("1")
                    ->comment('1 – "Com até 20.000 habitantes" / 
                                        2 – "De 20.001 até 50.000 habitantes" / 
                                        3 – "De 50.001 até 100.000 habitantes" / 
                                        4 – "De 100.001 até 500.000 habitantes" / 
                                        5 – "Com mais de 500.000 habitantes" - TIPO DE GRUPO POR HABITANTES');

                $table->decimal(self::NU_POPULACAO, 10, 0)
                    ->default(0)
                    ->comment('QUANTIDADE DE HABITANTES DO MUNICIPIO');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn(self::TB_MUNICIPIO, self::TP_GRUPO_MUNICIPIO)) {
            Schema::table(self::TB_MUNICIPIO, function (Blueprint $table) {
                $table->dropColumn(self::TP_GRUPO_MUNICIPIO);
                $table->dropColumn(self::NU_POPULACAO);
            });
        }
    }
}

