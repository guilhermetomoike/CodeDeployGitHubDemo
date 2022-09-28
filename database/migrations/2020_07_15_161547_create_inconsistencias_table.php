<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInconsistenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inconsistencias', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('tipos_inconsistencias_id')->nullable()->index('fk_inconsistencias_tipos_idx');
            $table->integer('empresas_id')->nullable()->index('fk_inconsistencias_empresas_idx');
            $table->integer('clientes_id')->nullable()->index('fk_inconsistencias_clientes_idx');
            $table->enum('status', ['PENDENTE', 'FINALIZADA'])->nullable();
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
        Schema::dropIfExists('inconsistencias');
    }
}
