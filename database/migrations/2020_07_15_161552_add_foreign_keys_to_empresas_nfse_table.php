<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToEmpresasNfseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empresas_nfse', function (Blueprint $table) {
            $table->foreign('empresas_id', 'fk_empresas_notas_empresas')->references('id')->on('empresas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('empresas_nfse', function (Blueprint $table) {
            $table->dropForeign('fk_empresas_notas_empresas');
        });
    }
}
