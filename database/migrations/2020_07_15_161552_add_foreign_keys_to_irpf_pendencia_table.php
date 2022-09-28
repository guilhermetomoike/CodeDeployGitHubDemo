<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToIrpfPendenciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('irpf_pendencia', function (Blueprint $table) {
            $table->foreign('irpf_questionario_id')->references('id')->on('irpf_questionario')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('irpf_pendencia', function (Blueprint $table) {
            $table->dropForeign('irpf_pendencia_irpf_questionario_id_foreign');
        });
    }
}
