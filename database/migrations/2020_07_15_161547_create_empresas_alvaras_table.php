<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasAlvarasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas_alvaras', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('empresa_id')->nullable()->index('fk_alvara_empresas_idx');
            $table->string('nome_arquivo')->nullable();
            $table->date('data_vencimento')->nullable();
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
        Schema::dropIfExists('empresas_alvaras');
    }
}
