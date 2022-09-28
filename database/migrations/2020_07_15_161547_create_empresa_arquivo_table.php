<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresaArquivoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresa_arquivo', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('empresa_id')->nullable()->index('fk_empresas_arquivos_diversos_empresas_idx');
            $table->string('nome', 80)->nullable();
            $table->string('tipo', 80)->nullable();
            $table->string('pasta')->nullable();
            $table->string('descricao')->nullable();
            $table->integer('usuarios_id')->nullable()->index('fk_empresas_arquivos_diversos_usuarios_idx');
            $table->dateTime('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empresa_arquivo');
    }
}
