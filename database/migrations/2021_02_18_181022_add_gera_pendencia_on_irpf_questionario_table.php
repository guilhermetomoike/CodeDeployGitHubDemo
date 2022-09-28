<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGeraPendenciaOnIrpfQuestionarioTable extends Migration
{
    public function up()
    {
        Schema::table('irpf_questionario', function (Blueprint $table) {
            $table->boolean('gera_pendencia')->nullable()->default(0)->after('visivel_cliente');
        });
    }

    public function down()
    {
        Schema::table('irpf_questionario', function (Blueprint $table) {
            $table->dropColumn('gera_pendencia');
        });
    }
}
