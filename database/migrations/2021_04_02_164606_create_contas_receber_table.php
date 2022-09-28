<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContasReceberTable extends Migration
{
    public function up()
    {
        Schema::create('contas_receber', function (Blueprint $table) {
            $table->id();
            $table->morphs('payer');
            $table->decimal('valor');
            $table->date('vencimento');
            $table->dateTime('consumed_at')->nullable();
            $table->string('descricao');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contas_receber');
    }
}
