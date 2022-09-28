<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecebimentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recebimentos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('instituicao');
            $table->string('horas_trabalhadas');
            $table->integer('atendimentos_realizados');
            $table->double('valor_total', 8, 2);
            $table->string('data_pagamento');
            $table->boolean('ja_pago')->default(0);
            $table->integer('cliente_id')->index('recebimentos_cliente_id_foreign');
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
        Schema::dropIfExists('recebimentos');
    }
}
