<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes_empresas', function (Blueprint $table) {
            $table->integer('clientes_id')->index('fk_clientes_has_empresas_clientes1_idx');
            $table->integer('empresas_id')->index('fk_clientes_has_empresas_empresas1_idx');
            $table->decimal('porcentagem_societaria', 10)->nullable();
            $table->tinyInteger('socio_administrador')->nullable();
            $table->boolean('prolabore_fixo')->default(0);
            $table->decimal('percentual_prolabore')->default(0.00);
            $table->decimal('valor_prolabore_fixo')->default(0.00);
            $table->primary(['clientes_id', 'empresas_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes_empresas');
    }
}
