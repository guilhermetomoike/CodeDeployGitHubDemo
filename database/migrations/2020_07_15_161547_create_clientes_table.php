<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('nome_completo');
            $table->string('rg', 100)->nullable();
            $table->string('cpf', 11);
            $table->string('situacao_cadastral', 45)->nullable();
            $table->string('email', 145)->nullable();
            $table->date('data_nascimento');
            $table->string('crm', 35)->nullable();
            $table->string('telefone_comercial', 25)->nullable();
            $table->string('telefone_celular', 25)->nullable();
            $table->tinyInteger('cadastro_completo')->nullable();
            $table->enum('sexo', ['M', 'F'])->nullable();
            $table->string('regime_casamento', 145)->nullable();
            $table->integer('profissao_id')->nullable();
            $table->string('especialidade')->nullable();
            $table->string('ies', 100)->nullable()->index('fk_clientes_ies1_idx');
            $table->string('senha', 45)->nullable();
            $table->boolean('ativo')->nullable();
            $table->string('nome_mae')->nullable();
            $table->tinyInteger('socio_administrador')->nullable();
            $table->enum('pipedrive_cadastro', ['NAO_VERIFICADO', 'VERIFICADO'])->nullable();
            $table->string('pis', 25)->nullable();
            $table->integer('tipo_usuario_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->string('nacionalidade', 80)->nullable();
            $table->boolean('fies')->nullable();
            $table->year('fies_conclusao')->nullable();
            $table->enum('residente', ['Já finalizei', 'Sim', 'Não'])->nullable();
            $table->year('residencia_conclusao')->nullable();
            $table->enum('pos_graduacao', ['Sim', 'Não', 'Ja terminei'])->nullable();
            $table->year('pos_graduacao_conclusao')->nullable();
            $table->string('recebe_pf', 150)->nullable();
            $table->string('local_trabalho')->nullable();
            $table->string('trabalha_por_producao')->nullable();
            $table->boolean('clinica_fisica')->nullable();
            $table->boolean('pretende_abrir_clinica_fisica')->nullable();
            $table->string('avatar')->nullable();
            $table->string('qualificacao', 100)->nullable();
            $table->boolean('acessou_app')->default(0);
            $table->string('device_id')->nullable();
            $table->boolean('acessou_web')->nullable()->default(0);
            $table->integer('estado_civil_id')->nullable();
            $table->integer('qualificacao_id')->nullable();
            $table->integer('especialidade_id')->nullable();
            $table->integer('ies_id')->nullable();
            $table->string('clicksign_key')->nullable();
            $table->string('iugu_id', 150)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}

