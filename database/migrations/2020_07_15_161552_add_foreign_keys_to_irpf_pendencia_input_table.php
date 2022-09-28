<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToIrpfPendenciaInputTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('irpf_pendencia_input', function (Blueprint $table) {
            $table->foreign('irpf_pendencia_id')->references('id')->on('irpf_pendencia')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('irpf_pendencia_input', function (Blueprint $table) {
            $table->dropForeign('irpf_pendencia_input_irpf_pendencia_id_foreign');
        });
    }
}
