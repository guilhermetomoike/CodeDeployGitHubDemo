<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTiposCertidoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipos_certidoes', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('nome', 55)->nullable();
            $table->string('descricao_emissao', 245)->nullable();
            $table->string('descricao_recebimento', 245)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipos_certidoes');
    }
}
