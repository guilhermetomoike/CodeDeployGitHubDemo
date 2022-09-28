<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataInicioCobrancaColumnOnEmpresaPreCadastrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empresa_pre_cadastros', function (Blueprint $table) {
            $table->date('data_inicio_cobranca')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('empresa_pre_cadastros', function (Blueprint $table) {
            $table->dropColumn('data_inicio_cobranca');
        });
    }
}
