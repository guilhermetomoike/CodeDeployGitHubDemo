<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropostasPadraoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('propostas_padrao', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo', 145);
            $table->mediumText('corpo');
            $table->string('cpf_cliente', 11);
            $table->boolean('aceitou')->nullable();
            $table->boolean('padrao')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('propostas_padrao');
    }
}
