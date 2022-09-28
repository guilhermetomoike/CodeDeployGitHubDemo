<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasPlanosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas_planos', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('empresas_id')->index('fk_empresas_has_planos_empresas1_idx');
            $table->integer('planos_id')->nullable()->index('fk_empresas_has_planos_planos1_idx');
            $table->unsignedTinyInteger('qtd')->nullable()->default(1);
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
        Schema::dropIfExists('empresas_planos');
    }
}
