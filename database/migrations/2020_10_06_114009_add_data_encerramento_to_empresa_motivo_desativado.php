<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataEncerramentoToEmpresaMotivoDesativado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empresa_motivo_desativado', function (Blueprint $table) {
            $table->date('data_encerramento')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('empresa_motivo_desativado', function (Blueprint $table) {
            $table->dropColumn('data_encerramento');
        });
    }
}
