<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasFaturamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas_faturamentos', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('empresas_id')->index('fk_empresas_faturamentos_empresas_idx');
            $table->integer('usuarios_id')->nullable();
            $table->decimal('faturamento', 10);
            $table->date('mes');
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empresas_faturamentos');
    }
}
