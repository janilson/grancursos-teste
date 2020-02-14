<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdesaoAddStAdesaoQuali extends Migration
{
    const ST_ADESAO_QUALI = 'ST_ADESAO_QUALI';
    const ST_PCF_QUALI = 'ST_PCF_QUALI';
    const ST_PROGREDIR_QUALI = 'ST_PROGREDIR_QUALI';
    const ST_PAA_QUALI = 'ST_PAA_QUALI';
    const ST_SENAPREDI_QUALI = 'ST_SENAPREDI_QUALI';
    const TB_ADESAO = 'TB_ADESAO';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn(self::TB_ADESAO, self::ST_ADESAO_QUALI)) {
            Schema::table(self::TB_ADESAO, function (Blueprint $table) {
                $table->char(self::ST_ADESAO_QUALI, 1)
                    ->default("0")
                    ->comment('0 - PARA "FALSE" / 1 - PARA "VERDADEIRO" - INDICA SE A QUALIFICAÇÃO DA ADESÃO ESTÁ MARCADA.');
            });
        }

        if (!Schema::hasColumn(self::TB_ADESAO, self::ST_PCF_QUALI)) {
            Schema::table(self::TB_ADESAO, function (Blueprint $table) {
                $table->char(self::ST_PCF_QUALI, 1)
                    ->default("0")
                    ->comment('0 - PARA "FALSE" / 1 - PARA "VERDADEIRO" - INDICA SE A QUALIFICAÇÃO DA PCF ESTÁ MARCADA.');
            });
        }

        if (!Schema::hasColumn(self::TB_ADESAO, self::ST_PROGREDIR_QUALI)) {
            Schema::table(self::TB_ADESAO, function (Blueprint $table) {
                $table->char(self::ST_PROGREDIR_QUALI, 1)
                    ->default("0")
                    ->comment('0 - PARA "FALSE" / 1 - PARA "VERDADEIRO" - INDICA SE A QUALIFICAÇÃO DO PROGREDIR ESTÁ MARCADA.');
            });
        }

        if (!Schema::hasColumn(self::TB_ADESAO, self::ST_PAA_QUALI)) {
            Schema::table(self::TB_ADESAO, function (Blueprint $table) {
                $table->char(self::ST_PAA_QUALI, 1)
                    ->default("0")
                    ->comment('0 - PARA "FALSE" / 1 - PARA "VERDADEIRO" - INDICA SE A QUALIFICAÇÃO DA PAA ESTÁ MARCADA.');
            });
        }

        if (!Schema::hasColumn(self::TB_ADESAO, self::ST_SENAPREDI_QUALI)) {
            Schema::table(self::TB_ADESAO, function (Blueprint $table) {
                $table->char(self::ST_SENAPREDI_QUALI, 1)
                    ->default("0")
                    ->comment('0 - PARA "FALSE" / 1 - PARA "VERDADEIRO" - INDICA SE A QUALIFICAÇÃO DO SENAPREDI ESTÁ MARCADA.');
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
        if (Schema::hasColumn(self::TB_ADESAO, self::ST_ADESAO_QUALI)) {
            Schema::table(self::TB_ADESAO, function (Blueprint $table) {
                $table->dropColumn(self::ST_ADESAO_QUALI);
            });
        }

        if (Schema::hasColumn(self::TB_ADESAO, self::ST_PCF_QUALI)) {
            Schema::table(self::TB_ADESAO, function (Blueprint $table) {
                $table->dropColumn(self::ST_PCF_QUALI);
            });
        }

        if (Schema::hasColumn(self::TB_ADESAO, self::ST_PROGREDIR_QUALI)) {
            Schema::table(self::TB_ADESAO, function (Blueprint $table) {
                $table->dropColumn(self::ST_PROGREDIR_QUALI);
            });
        }

        if (Schema::hasColumn(self::TB_ADESAO, self::ST_PAA_QUALI)) {
            Schema::table(self::TB_ADESAO, function (Blueprint $table) {
                $table->dropColumn(self::ST_PAA_QUALI);
            });
        }

        if (Schema::hasColumn(self::TB_ADESAO, self::ST_SENAPREDI_QUALI)) {
            Schema::table(self::TB_ADESAO, function (Blueprint $table) {
                $table->dropColumn(self::ST_SENAPREDI_QUALI);
            });
        }
    }
}
