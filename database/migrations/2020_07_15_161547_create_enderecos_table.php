<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnderecosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enderecos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('iptu')->nullable();
            $table->char('cep', 8);
            $table->string('logradouro');
            $table->string('numero', 10);
            $table->string('complemento')->nullable();
            $table->string('bairro', 100);
            $table->string('cidade');
            $table->char('uf', 2);
            $table->char('ibge', 7)->nullable();
            $table->timestamps();
            $table->string('addressable_type')->nullable();
            $table->unsignedBigInteger('addressable_id')->nullable();
            $table->index(['addressable_type', 'addressable_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enderecos');
    }
}
