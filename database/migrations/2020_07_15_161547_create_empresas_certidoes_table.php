<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasCertidoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas_certidoes', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('empresas_id')->nullable();
            $table->integer('certidoes_tipos')->nullable();
            $table->date('data_validade')->nullable();
            $table->timestamps();
            $table->string('nome_arquivo', 45)->nullable();
            $table->enum('apagada', ['SIM', 'NAO'])->nullable();
            $table->integer('ordens_de_servicos_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empresas_certidoes');
    }
}
