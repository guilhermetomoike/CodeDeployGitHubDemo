<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePegaPlantaoParceiroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pega_plantao_parceiro', function (Blueprint $table) {
            $table->bigInteger('Id', true);
            $table->string('Codigo', 14);
            $table->string('Nome', 100);
            $table->string('Url', 200);
            $table->string('Token', 100);
            $table->enum('Situacao', ['A', 'I'])->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pega_plantao_parceiro');
    }
}
