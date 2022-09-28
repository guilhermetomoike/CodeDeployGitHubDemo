<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClienteCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cliente_courses', function (Blueprint $table) {
            $table->id();
            $table->integer('cliente_id');
            $table->integer('course_id')->nullable();
            $table->integer('ies_id');
            $table->date('initial_date')->nullable();
            $table->date('conclusion_date')->nullable();
            $table->enum('status', ['inactive', 'active'])->default('active');
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
        Schema::dropIfExists('cliente_courses');
    }
}
