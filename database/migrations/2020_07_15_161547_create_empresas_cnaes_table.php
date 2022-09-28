<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasCnaesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas_cnaes', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('empresa_id')->nullable()->index('fk_empresas_cnaes_empresas_idx');
            $table->string('aliquota', 6)->nullable();
            $table->string('codigo', 45)->nullable();
            $table->string('descricao', 185)->nullable();
            $table->enum('principal', ['SIM', 'NAO'])->nullable()->default('NAO');
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
        Schema::dropIfExists('empresas_cnaes');
    }
}
