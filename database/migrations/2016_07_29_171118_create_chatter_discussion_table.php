<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChatterDiscussionTable extends Migration
{
    public function up()
    {
        Schema::create('chatter_discussion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chatter_category_id')->constrained('chatter_categories')->default('1')->onDelete('cascade')
                        ->onUpdate('cascade');;
            $table->string('title');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')
                        ->onUpdate('cascade');;
            $table->boolean('sticky')->default(false);
            $table->integer('views')->unsigned()->default('0');
            $table->boolean('answered')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('chatter_discussion');
    }
}
