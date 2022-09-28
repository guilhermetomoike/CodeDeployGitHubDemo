<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyRequiredGuides extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_required_guides', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('required_guide_id');
            $table->integer('empresa_id');
            $table->timestamps();

            $table->foreign('required_guide_id')->references('id')->on('required_guides');
            $table->foreign('empresa_id')->references('id')->on('empresas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_required_guides');
    }
}
