<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransacaoRecebimentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transacao_recebimento', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('id_externo', 50)->nullable();
            $table->string('chargeable_type');
            $table->unsignedBigInteger('chargeable_id');
            $table->string('method', 50)->nullable();
            $table->string('gatway', 50)->nullable();
            $table->decimal('valor');
            $table->enum('status', ['cancelada', 'processando', 'autorizada', 'rejeitada'])->nullable()->default('processando');
            $table->string('descricao', 150)->nullable();
            $table->json('request')->nullable();
            $table->json('response')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['chargeable_type', 'chargeable_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transacao_recebimento');
    }
}
