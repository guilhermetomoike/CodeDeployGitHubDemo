<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreCadastrosArquivosSociosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_cadastros_arquivos_socios', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('id_socio')->nullable()->index('fk_arquivos_clientes_medcontabil_empresas_idx');
            $table->integer('id_pre_cadastro')->nullable()->index('id_pre_cadastro');
            $table->string('tipo', 50)->nullable();
            $table->string('nome_arquivo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pre_cadastros_arquivos_socios');
    }
}
