<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToOsAtividadeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('os_atividade', function (Blueprint $table) {
            $table->foreign('ordem_servico_id')->references('id')->on('ordem_servico')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('os_atividade_base_id')->references('id')->on('os_atividade_base')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('os_item_id')->references('id')->on('os_item')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('os_atividade', function (Blueprint $table) {
            $table->dropForeign('os_atividade_ordem_servico_id_foreign');
            $table->dropForeign('os_atividade_os_atividade_base_id_foreign');
            $table->dropForeign('os_atividade_os_item_id_foreign');
        });
    }
}
