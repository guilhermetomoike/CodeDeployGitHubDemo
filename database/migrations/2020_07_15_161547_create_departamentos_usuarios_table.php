<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartamentosUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departamentos_usuarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('usuario_id')->index('departamentos_usuarios_usuario_id_foreign');
            $table->unsignedBigInteger('departamento_id')->index('departamentos_usuarios_departamento_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departamentos_usuarios');
    }
}
