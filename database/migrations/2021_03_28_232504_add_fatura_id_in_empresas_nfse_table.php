<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFaturaIdInEmpresasNfseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empresas_nfse', function (Blueprint $table) {
            $table->unsignedInteger('fatura_id')->nullable();
            $table->foreign('fatura_id')->references('id')->on('fatura');
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
            $table->dropColumn('fatura_id');
        });
    }
}
