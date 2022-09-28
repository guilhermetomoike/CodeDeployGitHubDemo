<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContadoresEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contadores_empresas', function (Blueprint $table) {
            $table->integer('empresas_id')->index('fk_empresas_has_usuarios_empresas4_idx');
            $table->integer('usuarios_id')->index('fk_empresas_has_usuarios_usuarios4_idx');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contadores_empresas');
    }
}
