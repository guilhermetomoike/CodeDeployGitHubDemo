<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipoFieldToEmpresasAcessosTable extends Migration
{
    public function up()
    {
        Schema::table('empresas_acessos', function (Blueprint $table) {
            $table->enum('tipo', ['emissor', 'alvara', 'prefeitura'])->default('emissor');
        });
    }

    public function down()
    {
        Schema::table('empresas_acessos', function (Blueprint $table) {
            $table->dropColumn('tipo');
        });
    }
}
