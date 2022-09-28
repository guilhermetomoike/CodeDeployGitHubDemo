<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOsAtividadeBaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('os_atividade_base', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('os_base_id')->index('os_atividade_base_os_base_id_foreign');
            $table->string('nome');
            $table->string('descricao');
            $table->json('input')->nullable();
            $table->integer('sla_hora')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('os_atividade_base');
    }
}
