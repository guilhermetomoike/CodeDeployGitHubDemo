<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToDepartamentosUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('departamentos_usuarios', function (Blueprint $table) {
            $table->foreign('departamento_id')->references('id')->on('departamentos')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('departamentos_usuarios', function (Blueprint $table) {
            $table->dropForeign('departamentos_usuarios_departamento_id_foreign');
            $table->dropForeign('departamentos_usuarios_usuario_id_foreign');
        });
    }
}
