<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageThreadParticipants extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('message_thread_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('thread_id')->constrained('message_threads')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('last_read')->nullable();
            $table->softDeletes();

            $table->unique(['thread_id', 'user_id']);
            // $table->foreign('thread_id')->references('id')->on('message_threads')->onDelete('cascade');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('message_thread_participants');
    }
}
