<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaturaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fatura', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('forma_pagamento_id')->nullable();
            $table->date('data_competencia')->nullable();
            $table->decimal('subtotal')->nullable();
            $table->decimal('desconto')->nullable();
            $table->date('data_vencimento')->nullable();
            $table->enum('status', ['pago', 'atrasado', 'pendente', 'aberto', 'cancelado', 'estornado', 'expirado', 'processando'])->nullable()->default('pendente');
            $table->date('data_recebimento')->nullable();
            $table->timestamps();
            $table->string('payer_type');
            $table->unsignedBigInteger('payer_id');
            $table->softDeletes();
            $table->string('arquivo', 100)->nullable();
            $table->string('gatway_fatura_id', 100)->nullable();
            $table->string('fatura_url', 150)->nullable();
            $table->bigInteger('em_conjunto')->nullable()->default(0);
            $table->decimal('juros')->nullable();
            $table->decimal('multa')->nullable();
            $table->index(['payer_type', 'payer_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fatura');
    }
}
