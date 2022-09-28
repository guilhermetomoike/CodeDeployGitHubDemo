<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToOsAtividadeBaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('os_atividade_base', function (Blueprint $table) {
            $table->foreign('os_base_id')->references('id')->on('os_base')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('os_atividade_base', function (Blueprint $table) {
            $table->dropForeign('os_atividade_base_os_base_id_foreign');
        });
    }
}
