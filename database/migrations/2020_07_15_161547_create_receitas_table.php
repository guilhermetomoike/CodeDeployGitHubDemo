<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receitas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('cliente_id')->index('receitas_cliente_id_foreign');
            $table->integer('empresa_id')->nullable()->index('receitas_empresa_id_foreign');
            $table->string('cnpj');
            $table->decimal('prolabore');
            $table->decimal('inss')->nullable();
            $table->decimal('irrf')->nullable();
            $table->decimal('fator_r')->nullable();
            $table->date('data_competencia');
            $table->timestamps();
            $table->softDeletes();
            $table->boolean('lancado')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receitas');
    }
}
