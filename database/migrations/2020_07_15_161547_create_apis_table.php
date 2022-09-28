<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apis', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('nome', 45)->nullable();
            $table->string('url', 145)->nullable();
            $table->string('url_teste', 55)->nullable();
            $table->string('token', 145)->nullable();
            $table->string('token_teste', 145)->nullable();
            $table->integer('requisicoes_restantes')->nullable();
            $table->integer('requisicoes_contratada')->nullable();
            $table->tinyInteger('ativo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apis');
    }
}
