<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToEmpresaServicoNfseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empresa_servico_nfse', function (Blueprint $table) {
            $table->foreign('empresa_id')->references('id')->on('empresas')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('servico_nfse_id')->references('id')->on('servico_nfse')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('tomador_id')->references('id')->on('tomador_nfse')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('empresa_servico_nfse', function (Blueprint $table) {
            $table->dropForeign('empresa_servico_nfse_empresa_id_foreign');
            $table->dropForeign('empresa_servico_nfse_servico_nfse_id_foreign');
            $table->dropForeign('empresa_servico_nfse_tomador_id_foreign');
        });
    }
}
