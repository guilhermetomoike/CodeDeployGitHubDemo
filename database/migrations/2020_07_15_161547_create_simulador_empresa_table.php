<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSimuladorEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('simulador_empresa', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('simulacao_id', 13)->nullable();
            $table->integer('empresa_numero')->nullable();
            $table->dateTime('hora_simulacao')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('simulador_empresa');
    }
}
