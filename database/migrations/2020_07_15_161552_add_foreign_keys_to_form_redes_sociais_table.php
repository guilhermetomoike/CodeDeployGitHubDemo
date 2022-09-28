<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToFormRedesSociaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('form_redes_sociais', function (Blueprint $table) {
            $table->foreign('cliente_id', 'fk_redes_sociais_cliente')->references('id_form_cliente')->on('form_cliente')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('form_redes_sociais', function (Blueprint $table) {
            $table->dropForeign('fk_redes_sociais_cliente');
        });
    }
}
