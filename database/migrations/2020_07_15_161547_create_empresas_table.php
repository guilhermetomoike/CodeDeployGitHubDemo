<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->integer('id', true);
            $table->enum('tipo_societario', ['Eireli', 'LTDA', 'Individual', 'Unipessoal'])->nullable();
            $table->string('nome_empresa')->nullable();
            $table->string('nome_1', 245)->nullable();
            $table->string('nome_2', 245)->nullable();
            $table->string('nome_3', 245)->nullable();
            $table->enum('regime_tributario', ['SN', 'Presumido', 'Isento'])->nullable();
            $table->string('cnpj', 14)->nullable();
            $table->date('data_viabilidade')->nullable();
            $table->text('objeto')->nullable();
            $table->decimal('capital_social', 10)->nullable();
            $table->enum('pagamento_irpj_csll', ['TRI', 'MEN'])->nullable();
            $table->tinyInteger('saiu')->nullable()->default(0);
            $table->tinyInteger('congelada')->nullable()->default(0);
            $table->string('atividade_principal')->nullable();
            $table->date('inicio_atividades')->nullable();
            $table->date('data_sn')->nullable();
            $table->string('porte', 45)->nullable();
            $table->enum('vinculo', ['MEDB', 'MEDCONTABIL'])->nullable()->default('MEDB');
            $table->string('inscricao_municipal', 35)->nullable();
            $table->unsignedTinyInteger('clinica_fisica')->nullable();
            $table->unsignedTinyInteger('crm_juridico')->nullable();
            $table->unsignedTinyInteger('inativo')->nullable();
            $table->string('estado_crm_juridico', 80)->nullable();
            $table->string('numero_crm_juridico', 10)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->string('codigo_acesso_simples', 20)->nullable();
            $table->string('nome_fantasia', 150)->nullable();
            $table->boolean('tem_cadastro_plugnotas')->unsigned()->nullable()->default(0);
            $table->string('iugu_id', 80)->nullable();
            $table->boolean('antecipacao_imposto')->unsigned()->nullable()->default(0);
            $table->string('razao_social')->nullable();
            $table->integer('status_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empresas');
    }
}
