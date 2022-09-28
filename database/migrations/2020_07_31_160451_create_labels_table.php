<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabelsTable extends Migration
{
    public function up()
    {
        Schema::create('labels', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('status')->default(1);
            $table->string('note')->nullable();
            $table->string('labelable_type')->nullable();
            $table->integer('labelable_id')->nullable();
            $table->index(['labelable_type', 'labelable_id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('labels');
    }
}
