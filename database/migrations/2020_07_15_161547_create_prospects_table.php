<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProspectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prospects', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('nome_doutor', 145)->nullable();
            $table->string('nome_contato', 145)->nullable();
            $table->string('email', 300)->nullable();
            $table->string('telefone', 10)->nullable();
            $table->string('celular', 11)->nullable();
            $table->enum('whatsapp', ['SIM', 'NAO']);
            $table->string('nome_empresa', 145)->nullable();
            $table->string('cnpj', 14)->nullable();
            $table->string('cidade', 45);
            $table->string('estado', 2);
            $table->enum('empresa_vinculo', ['MEDB', 'MEDCONTABIL', 'LAWB']);
            $table->enum('profissao', ['MEDICO', 'ENFERMEIRO', 'NUTRICIONISTA', 'ACADEMICO', 'BIOMEDICO', 'BIOQUIMICO', 'EDUCADORFISICO', 'FARMACIA', 'ADVOGADO', 'DENTISTA', 'FISIOTERAPEUTA', 'PSICOLOGO', 'ESTETICISTA', 'FONOAUDIOLOGO', 'FORMANDO']);
            $table->date('ano_formacao')->nullable();
            $table->string('ies', 45)->nullable();
            $table->string('especialidade', 145)->nullable();
            $table->enum('sexo', ['M', 'F'])->nullable();
            $table->integer('usuarios_id')->nullable();
            $table->timestamps();
            $table->enum('efetivado', ['SIM', 'NAO'])->nullable()->default('NAO');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prospects');
    }
}
