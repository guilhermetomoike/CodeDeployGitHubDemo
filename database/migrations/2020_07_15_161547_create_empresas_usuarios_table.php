<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas_usuarios', function (Blueprint $table) {
            $table->integer('empresas_id')->index('fk_empresas_has_usuarios_empresas1_idx');
            $table->integer('usuarios_id')->index('fk_empresas_has_usuarios_usuarios1_idx');
            $table->date('data_cadastro')->nullable();
            $table->primary(['empresas_id', 'usuarios_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empresas_usuarios');
    }
}
