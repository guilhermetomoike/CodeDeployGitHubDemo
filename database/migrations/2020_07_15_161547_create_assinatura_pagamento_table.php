<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssinaturaPagamentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assinatura_pagamento', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('payer_type');
            $table->unsignedBigInteger('payer_id');
            $table->string('gatway_id');
            $table->string('gatway', 50)->nullable();
            $table->softDeletes();
            $table->timestamps();
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
        Schema::dropIfExists('assinatura_pagamento');
    }
}
