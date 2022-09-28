<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePegaPlantaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pega_plantao', function (Blueprint $table) {
            $table->bigInteger('Id', true);
            $table->bigInteger('Parceiro');
            $table->string('ProfissionalPlantao', 200);
            $table->dateTime('InicioPlantao');
            $table->dateTime('FimPlantao');
            $table->double('Valor', 15, 2);
            $table->string('Descricao', 200);
            $table->string('CodigoProfissinalFixo', 100);
            $table->char('CodigoProfissionalPlantao', 100);
            $table->dateTime('CreatedAt');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pega_plantao');
    }
}
