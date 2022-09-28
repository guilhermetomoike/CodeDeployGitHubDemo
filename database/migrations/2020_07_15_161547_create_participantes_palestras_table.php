<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantesPalestrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participantes_palestras', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('palestras_id')->nullable()->index('fk_participantes_palestras_palestras');
            $table->string('nome_completo', 145)->nullable();
            $table->string('cidade_origem', 145)->nullable();
            $table->date('ano_formacao')->nullable();
            $table->string('telefone', 45)->nullable();
            $table->string('email', 45)->nullable();
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
        Schema::dropIfExists('participantes_palestras');
    }
}
