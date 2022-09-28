<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableCartaoCredito extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cartao_credito', function (Blueprint $table) {
            $table->dropForeign('cartao_credito_cliente_id_foreign');
            $table->dropColumn('vencimento', 'cliente_id');
            $table->year('ano')->nullable();
            $table->string('mes', 2)->nullable();
            $table->string('cartao_truncado', 30)->nullable();
            $table->string('dono_cartao')->nullable();
            $table->string('token_cartao', 60)->nullable()->change();
            $table->string('forma_pagamento_gatway_id', 100)->nullable();
            $table->boolean('invalido')->default(false);
            $table->boolean('principal')->default(true);
            $table->morphs('payer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cartao_credito', function (Blueprint $table) {
            $table->integer('cliente_id')->index('cartao_credito_cliente_id_foreign');
            $table->date('vencimento')->nullable();
            $table->dropColumn('ano', 'mes', 'cartao_truncado', 'dono_cartao', 'forma_pagamento_gatway_id', 'invalido', 'principal');
            $table->dropMorphs('payer');
        });
    }
}
