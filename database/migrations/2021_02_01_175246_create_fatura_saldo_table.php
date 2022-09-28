<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaturaSaldoTable extends Migration
{

    public function up()
    {
        Schema::create('fatura_saldo', function (Blueprint $table) {
            $table->id();
            $table->morphs('payer');
            $table->foreignId('fatura_id')->nullable();
            $table->string('descricao');
            $table->decimal('value');
            $table->string('value_type', 50)->default('brl');
            $table->date('competencia');
            $table->boolean('cumulative')->default(true);
            $table->dateTime('consumed_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fatura_saldo');
    }
}
