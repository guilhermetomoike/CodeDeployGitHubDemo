<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFranquiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('franquias', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('nome', 45)->nullable();
            $table->enum('vinculo', ['MEDB', 'MEDCONTABIL', 'LAWB']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('franquias');
    }
}
