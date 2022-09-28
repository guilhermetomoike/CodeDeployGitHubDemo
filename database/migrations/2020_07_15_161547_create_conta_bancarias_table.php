<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContaBancariasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conta_bancarias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('owner_type');
            $table->unsignedBigInteger('owner_id');
            $table->string('cpf_cnpj', 15)->nullable();
            $table->string('agencia', 10);
            $table->string('dv_agencia', 2)->nullable();
            $table->string('conta', 10);
            $table->string('dv_conta', 2)->nullable();
            $table->enum('tipo', ['p', 'c'])->default('c');
            $table->enum('pessoa', ['pf', 'pj'])->default('pf');
            $table->boolean('principal')->default(1);
            $table->integer('banco_id');
            $table->timestamps();
            $table->index(['owner_type', 'owner_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conta_bancarias');
    }
}
