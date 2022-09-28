<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreCadastrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_cadastros', function (Blueprint $table) {
            $table->integer('id', true);
            $table->enum('tipo_societario', ['Eireli', 'LTDA'])->nullable();
            $table->string('nome_completo')->nullable();
            $table->string('profissao', 80)->nullable();
            $table->string('cpf', 11)->nullable();
            $table->integer('estado_civil')->nullable();
            $table->string('rg', 10)->nullable();
            $table->date('data_nascimento')->nullable();
            $table->string('email', 50)->nullable();
            $table->string('telefone_celular', 25)->nullable();
            $table->enum('sexo', ['M', 'F'])->nullable();
            $table->string('nacionalidade', 50)->nullable();
            $table->unsignedInteger('qualificacao_id')->nullable();
            $table->integer('profissao_id')->nullable();
            $table->string('especialidade', 100)->nullable();
            $table->unsignedTinyInteger('clinica_fisica')->nullable();
            $table->enum('regime_tributario', ['SN', 'Presumido'])->nullable();
            $table->string('cep', 8)->nullable();
            $table->string('logradouro')->nullable();
            $table->string('complemento', 80)->nullable();
            $table->string('bairro')->nullable();
            $table->string('numero', 7)->nullable();
            $table->string('cidade', 150)->nullable();
            $table->char('uf', 2)->nullable();
            $table->integer('status_id')->nullable()->index('status_id_idx');
            $table->string('cnpj', 45)->nullable();
            $table->string('cnae', 45)->nullable();
            $table->string('inscricao_municipal', 45)->nullable();
            $table->date('data_validade_alvara')->nullable();
            $table->string('codigo_acesso_simples', 45)->nullable();
            $table->date('data_enquadramento')->nullable();
            $table->enum('operacao', ['A', 'T'])->nullable();
            $table->string('site_acesso_nota', 120)->nullable();
            $table->string('login', 80)->nullable();
            $table->string('senha', 80)->nullable();
            $table->string('senha_certificado', 45)->nullable();
            $table->string('motivo_exclusao')->nullable();
            $table->string('protocolo', 90)->nullable();
            $table->integer('empresa_id')->nullable()->index('empresa_id');
            $table->tinyInteger('transferencia')->nullable();
            $table->string('carta_transferencia')->nullable();
            $table->integer('cliente_id')->nullable();
            $table->date('updated_at')->nullable();
            $table->date('created_at')->nullable();
            $table->date('deleted_at')->nullable();
            $table->integer('usuario_id')->nullable();
            $table->string('observacao', 500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pre_cadastros');
    }
}
