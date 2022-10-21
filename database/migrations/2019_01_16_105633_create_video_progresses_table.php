<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoProgressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_progresses', function (Blueprint $table) {
            $table->id();
            // $table->integer('media_id')->unsigned();

            $table->foreignId('media_id')->constrained('media')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // $table->integer('user_id')->unsigned();
            $table->float('duration');
            $table->float('progress');
            $table->tinyInteger('complete')->default(0)->comment('0.Pending 1.Complete');
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
        Schema::dropIfExists('video_progresses');
    }
}
