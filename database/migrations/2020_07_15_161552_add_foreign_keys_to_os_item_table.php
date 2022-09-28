<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToOsItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('os_item', function (Blueprint $table) {
            $table->foreign('ordem_servico_id')->references('id')->on('ordem_servico')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('os_base_id')->references('id')->on('os_base')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('os_item', function (Blueprint $table) {
            $table->dropForeign('os_item_ordem_servico_id_foreign');
            $table->dropForeign('os_item_os_base_id_foreign');
            $table->dropForeign('os_item_usuario_id_foreign');
        });
    }
}
