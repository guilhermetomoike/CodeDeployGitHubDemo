<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guias', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('empresas_id');
            $table->enum('tipo', ['DAS', 'INSS', 'HONORARIOS', 'IRRF', 'FGTS', 'PIS', 'COFINS', 'IRPJ', 'CSLL', 'ISS', 'HOLERITE', 'IRPJ/CSLL', 'PIS/COFINS', 'OUTROS', ''])->nullable();
            $table->date('data_vencimento')->nullable();
            $table->date('data_competencia')->nullable();
            $table->dateTime('data_upload')->nullable();
            $table->integer('usuarios_id')->nullable();
            $table->string('nome_guia')->nullable();
            $table->tinyInteger('sem_guia')->nullable()->default(0);
            $table->tinyInteger('em_conjunto')->nullable()->default(0);
            $table->dateTime('data_estorno')->nullable();
            $table->integer('usuario_id_estorno')->nullable();
            $table->boolean('estornado')->default(0);
            $table->json('valor')->nullable();
            $table->json('erros')->nullable();
            $table->json('avisos')->nullable();
            $table->unique(['empresas_id', 'tipo', 'data_competencia', 'estornado', 'data_estorno'], 'guiassss');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guias');
    }
}
