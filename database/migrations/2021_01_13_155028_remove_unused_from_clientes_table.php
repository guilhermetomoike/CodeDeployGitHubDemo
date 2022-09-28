<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUnusedFromClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropColumn([
                'situacao_cadastral',
                'crm',
                'telefone_comercial',
                'telefone_celular',
                'cadastro_completo',
                'especialidade',
                'ies',
                'ativo',
                'socio_administrador',
                'pipedrive_cadastro',
                'tipo_usuario_id',
                'fies',
                'fies_conclusao',
                'residente',
                'residencia_conclusao',
                'pos_graduacao',
                'pos_graduacao_conclusao',
                'recebe_pf',
                'local_trabalho',
                'trabalha_por_producao',
                'pretende_abrir_clinica_fisica',
                'acessou_app',
                'device_id',
                'acessou_web',
                'ies_id',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clientes', function (Blueprint $table) {
            //
        });
    }
}
