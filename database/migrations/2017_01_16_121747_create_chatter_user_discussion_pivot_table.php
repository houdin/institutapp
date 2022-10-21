<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChatterUserDiscussionPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chatter_user_discussion', function (Blueprint $table) {
            // $table->integer('user_id')->unsigned()->index();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->index();
            // $table->integer('discussion_id')->unsigned()->index();
            $table->foreignId('discussion_id')->constrained('chatter_discussion')->onDelete('cascade');
            // $table->foreign('discussion_id')->references('id')->on('chatter_discussion')->onDelete('cascade');
            $table->primary(['user_id', 'discussion_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('chatter_user_discussion');
    }
}
