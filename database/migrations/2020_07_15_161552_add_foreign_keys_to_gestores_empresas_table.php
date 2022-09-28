<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToGestoresEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gestores_empresas', function (Blueprint $table) {
            $table->foreign('empresas_id', 'fk_empresas_has_usuarios_empresas2')->references('id')->on('empresas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('usuarios_id', 'fk_empresas_has_usuarios_usuarios2')->references('id')->on('usuarios')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gestores_empresas', function (Blueprint $table) {
            $table->dropForeign('fk_empresas_has_usuarios_empresas2');
            $table->dropForeign('fk_empresas_has_usuarios_usuarios2');
        });
    }
}
