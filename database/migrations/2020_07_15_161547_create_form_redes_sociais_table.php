<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormRedesSociaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_redes_sociais', function (Blueprint $table) {
            $table->integer('id_rede_social', true);
            $table->string('facebook', 1);
            $table->string('instagram', 1);
            $table->string('linkedin', 1);
            $table->string('twitter', 1);
            $table->string('whatsapp', 1);
            $table->string('youtube', 1);
            $table->string('outros', 1);
            $table->integer('cliente_id')->index('fk_redes_sociais_cliente_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_redes_sociais');
    }
}
