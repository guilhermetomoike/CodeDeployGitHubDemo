<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOsItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('os_item', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('os_base_id')->index('os_item_os_base_id_foreign');
            $table->unsignedBigInteger('ordem_servico_id')->index('os_item_ordem_servico_id_foreign');
            $table->dateTime('data_limite');
            $table->decimal('preco')->default(0.00);
            $table->integer('usuario_id')->nullable()->index('os_item_usuario_id_foreign');
            $table->dateTime('competencia')->nullable();
            $table->string('motivo_cancelamento')->nullable();
            $table->dateTime('email_enviado')->nullable();
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
        Schema::dropIfExists('os_item');
    }
}
