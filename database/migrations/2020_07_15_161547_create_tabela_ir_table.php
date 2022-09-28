<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTabelaIrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabela_ir', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('base_calculo_from');
            $table->decimal('base_calculo_to')->nullable();
            $table->decimal('aliquota', 5);
            $table->decimal('deducao');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tabela_ir');
    }
}
