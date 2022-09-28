<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTomadorNfseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tomador_nfse', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cpf_cnpj', 14);
            $table->string('razao_social', 150);
            $table->string('email', 80)->nullable();
            $table->string('tipo_logradouro', 30)->nullable();
            $table->string('logradouro', 80)->nullable();
            $table->string('numero', 10)->nullable();
            $table->string('complemento', 100)->nullable();
            $table->string('bairro', 50)->nullable();
            $table->string('codigo_cidade', 10)->nullable();
            $table->string('descricao_cidade', 50)->nullable();
            $table->string('estado', 5)->nullable();
            $table->string('cep', 10)->nullable();
            $table->boolean('tem_cadastro_plugnotas')->default(0);
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
        Schema::dropIfExists('tomador_nfse');
    }
}
