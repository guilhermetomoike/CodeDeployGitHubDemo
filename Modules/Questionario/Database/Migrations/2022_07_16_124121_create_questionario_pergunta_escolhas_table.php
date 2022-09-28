<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionarioPerguntaEscolhasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('questionario_pergunta_escolhas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('questionario_pergunta_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('escolha', 512)->nullable();
            $table->enum('tipo', ["tx","im","bt"])->default('tx');
            $table->boolean('outro_informar')->default(0);
            $table->string('mostrar_se_resposta', 512)->nullable();
            $table->foreignId('mostrar_se_pergunta_id')->nullable()->constrained('questionario_perguntas')->nullOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('questionario_pergunta_escolhas');
    }
}
