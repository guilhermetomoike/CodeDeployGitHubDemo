<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTiposInconsistenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipos_inconsistencias', function (Blueprint $table) {
            $table->integer('id', true);
            $table->enum('tipo', ['E_SEM_EMAIL'])->nullable();
            $table->string('titulo', 145)->nullable();
            $table->string('descricao', 345)->nullable();
            $table->enum('prioridade', ['Alta', 'Médica', 'Leve'])->nullable();
            $table->string('cor', 25)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipos_inconsistencias');
    }
}
