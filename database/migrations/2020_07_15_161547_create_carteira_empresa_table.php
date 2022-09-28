<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarteiraEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carteira_empresa', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('carteira_id')->index('carteira_empresa_carteira_id_foreign');
            $table->integer('empresa_id')->index('carteira_empresa_empresa_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carteira_empresa');
    }
}
