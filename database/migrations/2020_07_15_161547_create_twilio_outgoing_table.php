<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTwilioOutgoingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('twilio_outgoing', function (Blueprint $table) {
            $table->string('account_sid', 100)->nullable();
            $table->text('body')->nullable();
            $table->string('error_code')->nullable();
            $table->string('error_message')->nullable();
            $table->string('from', 80)->nullable();
            $table->string('messaging_service_sid', 100)->nullable();
            $table->tinyInteger('num_media')->nullable();
            $table->tinyInteger('num_segments')->nullable();
            $table->string('price', 20)->nullable();
            $table->string('price_unit', 20)->nullable();
            $table->string('sid', 100)->nullable();
            $table->string('status', 100)->nullable();
            $table->json('media')->nullable();
            $table->string('to', 80)->nullable();
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
        Schema::dropIfExists('twilio_outgoing');
    }
}
