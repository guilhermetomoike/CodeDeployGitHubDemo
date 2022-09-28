<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToContadoresEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contadores_empresas', function (Blueprint $table) {
            $table->foreign('empresas_id', 'fk_empresas_has_usuarios_empresas4')->references('id')->on('empresas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('usuarios_id', 'fk_empresas_has_usuarios_usuarios4')->references('id')->on('usuarios')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contadores_empresas', function (Blueprint $table) {
            $table->dropForeign('fk_empresas_has_usuarios_empresas4');
            $table->dropForeign('fk_empresas_has_usuarios_usuarios4');
        });
    }
}
