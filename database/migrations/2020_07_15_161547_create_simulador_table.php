<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSimuladorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('simulador', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('id_simulacao', 13)->nullable();
            $table->decimal('faturamento', 10)->nullable();
            $table->decimal('prolabore', 10)->nullable();
            $table->decimal('cpp', 10)->nullable();
            $table->string('mes', 10)->nullable();
            $table->string('ano', 5)->nullable();
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
        Schema::dropIfExists('simulador');
    }
}
