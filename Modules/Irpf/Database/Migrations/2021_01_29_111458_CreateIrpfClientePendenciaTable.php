<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIrpfClientePendenciaTable extends Migration
{
    public function up()
    {
        Schema::create('irpf_cliente_pendencia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('irpf_pendencia_id');
            $table->foreignId('declaracao_irpf_id');
            $table->json('inputs')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('irpf_cliente_pendencia');
    }
}
