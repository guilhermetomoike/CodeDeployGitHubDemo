<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIrpfPendenciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('irpf_pendencia', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('irpf_questionario_id')->index('irpf_pendencia_irpf_questionario_id_foreign');
            $table->string('nome', 100);
            $table->string('descricao', 200)->nullable();
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
        Schema::dropIfExists('irpf_pendencia');
    }
}
