<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            
            $table->id();
            $table->unsignedBigInteger('channel_id');
            $table->unsignedBigInteger('sender_id');
            $table->string('message');
            $table->boolean('seen')->default(false);
            $table->unsignedBigInteger('reply_to')->nullable();
            $table->timestamps();

            $table->foreign('channel_id')->references('id')->on('channels')->cascadeOnDelete();
            $table->foreign('sender_id')->references('id')->on('users')->cascadeOnDelete();

            /**
             * not making reply_to column as a foreign eventhough it is referencing the messages (this) table
             * reason: if a message that is replied to is deleted, either the reply message will be deleted or there will be an error. 
             */

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
