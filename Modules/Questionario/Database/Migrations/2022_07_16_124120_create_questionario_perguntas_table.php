<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionarioPerguntasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('questionario_perguntas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('questionario_parte_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('titulo', 512)->nullable();
            $table->string('subtitulo', 512)->nullable();
            $table->string('url_imagem', 512)->nullable();
            $table->boolean('obrigatoria')->default(1);
            $table->enum('tipo', ["me","ue","tl","tc","dt","nu","vl","in","or"]);
            $table->enum('tipo_escolha', ["hz","vt","cb"])->nullable();
            $table->integer('min')->default(0);
            $table->integer('max')->default(0);
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
        Schema::dropIfExists('questionario_perguntas');
    }
}
