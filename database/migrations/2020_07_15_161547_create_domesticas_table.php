<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDomesticasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('domesticas', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('cliente_id')->nullable()->index('fk_domesticas_clientes_idx');
            $table->string('nome', 200)->nullable();
            $table->string('cpf', 11)->nullable();
            $table->string('cep', 45)->nullable();
            $table->string('logradouro', 200)->nullable();
            $table->string('numero', 45)->nullable();
            $table->string('bairro', 45)->nullable();
            $table->string('cidade', 200)->nullable();
            $table->string('uf', 45)->nullable();
            $table->string('complemento', 200)->nullable();
            $table->dateTime('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('domesticas');
    }
}
