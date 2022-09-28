<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIrpfPendenciaInputTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('irpf_pendencia_input', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('irpf_pendencia_id')->index('irpf_pendencia_input_irpf_pendencia_id_foreign');
            $table->string('type', 50);
            $table->string('label', 100);
            $table->string('name', 50);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('irpf_pendencia_input');
    }
}
