<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIrpfItemEnviadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('irpf_item_enviado', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type', 50);
            $table->string('label', 100)->nullable();
            $table->string('name', 50);
            $table->string('value', 200);
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('irpf_cliente_resposta_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('irpf_item_enviado');
    }
}
