<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionarioRespostasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('questionario_respostas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('questionario_pergunta_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('questionario_pergunta_escolha_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('respondente', 255)->index();
            $table->string('resposta', 512)->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questionario_respostas');
    }
}
