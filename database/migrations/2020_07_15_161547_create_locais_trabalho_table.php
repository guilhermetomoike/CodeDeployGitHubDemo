<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocaisTrabalhoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locais_trabalho', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('estado', 45)->nullable();
            $table->string('cidade', 45)->nullable();
            $table->string('nome_local', 45)->nullable();
            $table->string('contato', 45)->nullable();
            $table->integer('telefone')->nullable();
            $table->string('edital', 45)->nullable();
            $table->date('validade')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locais_trabalho');
    }
}
