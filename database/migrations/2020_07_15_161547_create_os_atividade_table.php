<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOsAtividadeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('os_atividade', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('os_atividade_base_id')->index('os_atividade_os_atividade_base_id_foreign');
            $table->unsignedBigInteger('ordem_servico_id')->index('os_atividade_ordem_servico_id_foreign');
            $table->unsignedBigInteger('os_item_id')->index('os_atividade_os_item_id_foreign');
            $table->dateTime('data_inicio')->nullable();
            $table->dateTime('data_fim')->nullable();
            $table->json('input')->nullable();
            $table->enum('status', ['pendente', 'concluido'])->default('pendente');
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
        Schema::dropIfExists('os_atividade');
    }
}
