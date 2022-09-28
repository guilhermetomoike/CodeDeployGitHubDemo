<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('cliente_id')->nullable()->index('fk_documentos_clientes1_idx');
            $table->string('nome_documento', 25)->nullable();
            $table->string('numero', 25)->nullable();
            $table->date('data_emissao')->nullable();
            $table->string('orgao_expedidor', 45)->nullable();
            $table->string('naturalidade', 45)->nullable();
            $table->date('validade')->nullable();
            $table->enum('tipo_documento', ['RG', 'RNE', 'CNH', 'P', 'CRM'])->nullable();
            $table->string('uf', 2)->nullable();
            $table->string('caminho', 155)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documentos');
    }
}
