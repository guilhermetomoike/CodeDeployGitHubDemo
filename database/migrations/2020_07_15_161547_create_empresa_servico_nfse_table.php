<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresaServicoNfseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresa_servico_nfse', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('empresa_id')->index('empresa_servico_nfse_empresa_id_foreign');
            $table->unsignedBigInteger('tomador_id')->index('empresa_servico_nfse_tomador_id_foreign');
            $table->unsignedBigInteger('servico_nfse_id')->index('empresa_servico_nfse_servico_nfse_id_foreign');
            $table->string('aliquota', 15);
            $table->boolean('iss_retido')->default(0);
            $table->string('discriminacao', 700)->nullable();
            $table->json('retencao')->nullable();
            $table->decimal('valor');
            $table->string('email_envio', 80);
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
        Schema::dropIfExists('empresa_servico_nfse');
    }
}
