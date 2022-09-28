<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasAcessosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas_acessos', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('login', 45)->nullable();
            $table->string('senha', 45)->nullable();
            $table->string('site', 405)->nullable();
            $table->integer('empresas_id')->index('fk_acessos_empresas1_idx');
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
        Schema::dropIfExists('empresas_acessos');
    }
}
