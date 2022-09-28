<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArquivosClientesMedcontabilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arquivos_clientes_medcontabil', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('empresas_id')->nullable()->index('fk_arquivos_clientes_medcontabil_empresas_idx');
            $table->string('nome_arquivo', 45)->nullable();
            $table->string('tipo', 45)->nullable();
            $table->string('created_at', 45)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arquivos_clientes_medcontabil');
    }
}
