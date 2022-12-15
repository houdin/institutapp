<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChatterPostTable extends Migration
{
    public function up()
    {
        Schema::create('chatter_post', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chatter_discussion_id')->constrained('chatter_discussion')->onDelete('cascade')
                ->onUpdate('cascade');;
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')
                ->onUpdate('cascade');;
            $table->text('body');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('chatter_post');
    }
}
