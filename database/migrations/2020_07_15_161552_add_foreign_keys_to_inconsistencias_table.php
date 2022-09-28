<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToInconsistenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inconsistencias', function (Blueprint $table) {
            $table->foreign('clientes_id', 'fk_inconsistencias_clientes')->references('id')->on('clientes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('empresas_id', 'fk_inconsistencias_empresas')->references('id')->on('empresas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('tipos_inconsistencias_id', 'fk_inconsistencias_tipos')->references('id')->on('tipos_inconsistencias')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inconsistencias', function (Blueprint $table) {
            $table->dropForeign('fk_inconsistencias_clientes');
            $table->dropForeign('fk_inconsistencias_empresas');
            $table->dropForeign('fk_inconsistencias_tipos');
        });
    }
}
