<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGestoresEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gestores_empresas', function (Blueprint $table) {
            $table->integer('empresas_id');
            $table->integer('usuarios_id')->index('fk_empresas_has_usuarios_usuarios2_idx');
            $table->timestamps();
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
        Schema::dropIfExists('gestores_empresas');
    }
}
