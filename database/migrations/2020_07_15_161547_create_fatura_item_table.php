<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaturaItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fatura_item', function (Blueprint $table) {
            $table->increments('id');
            $table->string('valor')->nullable();
            $table->integer('planos_id')->nullable();
            $table->unsignedInteger('fatura_id')->index('fatura_id');
            $table->tinyInteger('qtd')->nullable();
            $table->timestamps();
            $table->string('descricao', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fatura_item');
    }
}
