<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTwilioIncomingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('twilio_incoming', function (Blueprint $table) {
            $table->string('SmsMessageSid', 100)->nullable();
            $table->tinyInteger('NumMedia')->nullable();
            $table->string('SmsSid', 100)->nullable();
            $table->string('SmsStatus', 100)->nullable();
            $table->text('Body')->nullable();
            $table->string('To', 80)->nullable();
            $table->tinyInteger('NumSegments')->nullable();
            $table->string('MessageSid', 100)->nullable();
            $table->string('AccountSid', 100)->nullable();
            $table->string('From', 100)->nullable();
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
        Schema::dropIfExists('twilio_incoming');
    }
}
