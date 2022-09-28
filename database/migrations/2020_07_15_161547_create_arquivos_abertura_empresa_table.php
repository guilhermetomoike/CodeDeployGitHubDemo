<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArquivosAberturaEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arquivos_abertura_empresa', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('pre_cadastro_id')->nullable()->index('pre_cadastro_id_idx');
            $table->string('local_arquivo', 45)->nullable();
            $table->string('nome_arquivo', 45)->nullable();
            $table->date('created_at')->nullable();
            $table->integer('status_id')->nullable()->index('status_id_idx');
            $table->string('input', 45)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arquivos_abertura_empresa');
    }
}
