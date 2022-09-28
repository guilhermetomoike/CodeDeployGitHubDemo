<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJuntaComercialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('junta_comercials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estado_id')->nullable();
            $table->decimal('taxa_alteracao', 8, 2)->nullable();
            $table->decimal('taxa_alteracao_extra', 8, 2)->nullable();
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
        Schema::dropIfExists('junta_comercials');
    }
}
