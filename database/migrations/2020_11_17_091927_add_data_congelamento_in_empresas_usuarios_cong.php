<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataCongelamentoInEmpresasUsuariosCong extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empresas_usuarios_cong', function (Blueprint $table) {
            $table->date('freeze_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('empresas_usuarios_cong', function (Blueprint $table) {
            $table->dropColumn('freeze_date');
        });
    }
}
