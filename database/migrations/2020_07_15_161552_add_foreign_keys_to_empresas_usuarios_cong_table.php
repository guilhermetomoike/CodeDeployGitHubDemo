<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToEmpresasUsuariosCongTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empresas_usuarios_cong', function (Blueprint $table) {
            $table->foreign('empresas_id', 'fk_empresas_has_usuarios_empresas3')->references('id')->on('empresas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('usuarios_id', 'fk_empresas_has_usuarios_usuarios3')->references('id')->on('usuarios')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('empresas_usuarios_cong', function (Blueprint $table) {
            $table->dropForeign('fk_empresas_has_usuarios_empresas3');
            $table->dropForeign('fk_empresas_has_usuarios_usuarios3');
        });
    }
}
