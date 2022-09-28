<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasLiberacoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas_liberacoes', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('empresas_id')->nullable();
            $table->date('data_competencia')->nullable();
            $table->timestamps();
            $table->enum('liberada', ['SIM', 'NAO'])->nullable()->default('SIM');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empresas_liberacoes');
    }
}
