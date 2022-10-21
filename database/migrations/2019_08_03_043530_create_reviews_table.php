<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            // $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->nullableMorphs('reviewable');

            $table->integer('rating')->nullable();
            $table->text('content')->nullable();
            // $table->integer('product_id')->unsigned();
            // $table->longText('review', 500);
            $table->timestamps();

            // $table->foreign('product_id')
            //     ->references('id')
            //     ->on('products')
            //     ->onDelete('cascade');
            // $table->foreign('user_id')
            //     ->references('id')
            //     ->on('users')
            //     ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
