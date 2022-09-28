<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIrpfQuestionarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('irpf_questionario', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pergunta');
            $table->boolean('quantitativo')->nullable()->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->boolean('visivel_cliente')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('irpf_questionario');
    }
}
