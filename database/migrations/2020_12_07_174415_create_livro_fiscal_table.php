<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLivroFiscalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('livro_fiscal', function (Blueprint $table) {
            $table->id();
            $table->integer('empresa_id');
            $table->year('ano');
            $table->enum('status', ['justificado', 'entregue', 'pendente'])->default('pendente');
            $table->string('observacao')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('livro_fiscal');
    }
}
