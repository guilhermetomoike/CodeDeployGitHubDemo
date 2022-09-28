<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIrpfClienteRespostaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('irpf_cliente_resposta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('cliente_id')->nullable()->index('irpf_cliente_resposta_cliente_id_foreign');
            $table->unsignedBigInteger('irpf_questionario_id')->index('irpf_cliente_resposta_irpf_questionario_id_foreign');
            $table->boolean('resposta');
            $table->decimal('quantidade')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('declaracao_irpf_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('irpf_cliente_resposta');
    }
}
