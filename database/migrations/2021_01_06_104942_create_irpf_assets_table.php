<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIrpfAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('irpf_assets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('irpf_id');
            $table->integer('code');
            $table->string('description');
            $table->decimal('value');
            $table->timestamps();

            $table->foreign('irpf_id')->references('id')->on('declaracao_irpf');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('irpf_assets');
    }
}
