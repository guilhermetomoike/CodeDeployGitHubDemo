<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColInIrpfItemEnviadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('irpf_item_enviado', function (Blueprint $table) {
            $table->foreignId('irpf_pendencia_id')->after('id');
            $table->foreignId('irpf_pendencia_input_id')->after('id');
            $table->string('name', 50)->nullable()->change();
            $table->string('value', 200)->nullable()->change();
            $table->dropColumn('type', 'label');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('irpf_item_enviado', function (Blueprint $table) {
            $table->dropColumn('irpf_pendencia_id', 'irpf_pendencia_input_id');
            $table->string('type', 50)->nullable();
            $table->string('label', 50)->nullable();
        });
    }
}
