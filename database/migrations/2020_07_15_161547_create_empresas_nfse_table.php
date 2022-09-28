<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasNfseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas_nfse', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('empresas_id')->index('fk_empresas_notas_empresas_idx');
            $table->string('prestador', 25)->nullable();
            $table->string('tomador', 25)->nullable();
            $table->string('numero_nfse', 25)->nullable();
            $table->decimal('valor_nota', 10)->nullable();
            $table->string('id_tecnospeed', 45)->nullable();
            $table->string('status', 45)->nullable();
            $table->string('protocol', 145)->nullable();
            $table->string('mensagem', 500)->nullable();
            $table->string('arquivo', 100)->nullable();
            $table->timestamps();
            $table->string('serie', 45)->nullable();
            $table->string('lote', 15)->nullable();
            $table->string('codigo_verificacao', 80)->nullable();
            $table->date('data_autorizacao')->nullable();
            $table->string('mensagem_retorno', 800)->nullable();
            $table->date('emissao')->nullable();
            $table->date('cancelada_at')->nullable();
            $table->date('previsao_recebimento')->nullable();
            $table->softDeletes();
            $table->longText('payload')->nullable();
            $table->string('pdf_externo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empresas_nfse');
    }
}
