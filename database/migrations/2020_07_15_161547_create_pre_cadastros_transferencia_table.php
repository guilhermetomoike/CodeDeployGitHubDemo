<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreCadastrosTransferenciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_cadastros_transferencia', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('id_pre_cadastro')->nullable()->index('id_pre_cadastro');
            $table->string('razaoSocial')->nullable();
            $table->string('cpf', 11)->nullable();
            $table->string('cnpj', 14)->nullable();
            $table->date('competencia_inicio')->nullable();
            $table->string('escritorio_antigo', 150)->nullable();
            $table->char('enviar_contrato', 1)->nullable();
            $table->date('data_visita')->nullable();
            $table->string('arquivo')->nullable();
            $table->date('data_primeiro_honorario')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pre_cadastros_transferencia');
    }
}
