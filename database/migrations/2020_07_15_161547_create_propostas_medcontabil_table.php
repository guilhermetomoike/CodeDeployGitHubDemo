<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropostasMedcontabilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('propostas_medcontabil', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('aos_cuidados', 245)->nullable();
            $table->string('empresa_nome', 245)->nullable();
            $table->integer('mensalidade_faixa')->nullable();
            $table->integer('socios')->nullable();
            $table->integer('funcionarios')->nullable();
            $table->decimal('valor_total', 10)->nullable();
            $table->decimal('economia_total', 10)->nullable();
            $table->enum('aceitou', ['SIM', 'NAO', 'SEM_RESPOSTA'])->nullable()->default('SEM_RESPOSTA');
            $table->enum('paga_decimo', ['SIM', 'NAO'])->nullable();
            $table->string('caminho_imagem', 245)->nullable();
            $table->string('email_usuario', 145)->nullable();
            $table->string('telefone_usuario', 15)->nullable();
            $table->decimal('total_atual', 10)->nullable();
            $table->string('nome_usuario')->nullable();
            $table->string('proposal', 145)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('propostas_medcontabil');
    }
}
