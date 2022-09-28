<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contratos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('dia_vencimento', 2)->nullable();
            $table->date('primeira_mensalidade')->nullable();
            $table->integer('empresas_id')->index('fk_contratos_empresas1_idx');
            $table->decimal('desconto')->nullable();
            $table->integer('forma_pagamento_id')->nullable();
            $table->timestamps();
            $table->string('forma_pagamento_gatway_id', 100)->nullable();
            $table->json('forma_pagamento_gatway_data')->nullable();
            $table->decimal('teto_cobranca')->nullable();
            $table->json('extra')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contratos');
    }
}
