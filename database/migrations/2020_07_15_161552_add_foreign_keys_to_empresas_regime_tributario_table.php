<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToEmpresasRegimeTributarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empresas_regime_tributario', function (Blueprint $table) {
            $table->foreign('empresas_id', 'fk_regime_tributario_empresas')->references('id')->on('empresas')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('empresas_regime_tributario', function (Blueprint $table) {
            $table->dropForeign('fk_regime_tributario_empresas');
        });
    }
}
