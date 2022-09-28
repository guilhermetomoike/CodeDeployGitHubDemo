<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovimentoContasReceberTable extends Migration
{
    public function up()
    {
        Schema::create('movimento_contas_receber', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contas_receber_id');
            $table->decimal('valor');
            $table->string('descricao');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('movimento_contas_receber');
    }
}
