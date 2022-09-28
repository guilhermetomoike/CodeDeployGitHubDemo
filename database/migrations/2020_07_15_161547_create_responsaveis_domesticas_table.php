<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponsaveisDomesticasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responsaveis_domesticas', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('nome_completo')->nullable();
            $table->string('cpf', 45)->nullable();
            $table->string('cep', 45)->nullable();
            $table->string('logradouro', 45)->nullable();
            $table->string('numero', 45)->nullable();
            $table->string('bairro', 45)->nullable();
            $table->string('cidade', 45)->nullable();
            $table->string('uf', 45)->nullable();
            $table->string('complemento', 45)->nullable();
            $table->string('created_at', 45)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('responsaveis_domesticas');
    }
}
