<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasDesativadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas_desativadas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('empresas_id')->nullable();
            $table->unsignedInteger('motivo_desativar_id')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->dateTime('data_competencia')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empresas_desativadas');
    }
}
