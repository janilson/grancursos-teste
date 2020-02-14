<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNoRegiao extends Migration
{
    const NO_REGIAO = 'no_regiao';
    const TB_UF = 'tb_uf';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn(self::TB_UF, self::NO_REGIAO)) {
            Schema::table(self::TB_UF, function (Blueprint $table) {
                $table->string(self::NO_REGIAO, 50)
                    ->nullable(true)
                    ->comment('NOME DA REGIÃO A QUAL A UF PERTENCE');
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
        if (Schema::hasColumn(self::TB_UF, self::NO_REGIAO)) {
            Schema::table(self::TB_UF, function (Blueprint $table) {
                $table->dropColumn(self::NO_REGIAO);
            });
        }
    }
}
