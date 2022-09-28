<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description');
            $table->decimal('price')->default(0.00);
            $table->integer('interval')->default(1);
            $table->enum('interval_type', ['daily', 'weekly', 'monthly'])->default('monthly');
            $table->enum('payable_with', ['all', 'credit_card', 'bank_slip'])->default('all');
            $table->softDeletes();
            $table->timestamps();
            $table->date('start_on')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
}
