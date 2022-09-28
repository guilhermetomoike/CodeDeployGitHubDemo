<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViabilidadeMunicipalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('viabilidade_municipal', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->char('cidade_id', 6);
            $table->boolean('alvara_endereco_fiscal');
            $table->string('cnae_exigido')->nullable();
            $table->boolean('vigilancia');
            $table->integer('tempo_emissao_alvara');
            $table->integer('tempo_emissao_licenca_sanitaria')->nullable();
            $table->decimal('valor_licenca_sanitaria')->nullable();
            $table->decimal('valor_alvara');
            $table->decimal('percentual_iss');
            $table->boolean('abertura_area_rual');
            $table->longText('observacoes')->nullable();
            $table->tinyInteger('mes_renovacao_alvara');
            $table->boolean('crm_juridico');
            $table->enum('nfs_eletronica_manual', ['eletronica', 'manual']);
            $table->enum('modelo_solicitacao', ['presencial', 'email', 'site']);
            $table->json('documentos_necessarios')->nullable();
            $table->string('modelo_solicitacao_site')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('viabilidade_municipal');
    }
}
