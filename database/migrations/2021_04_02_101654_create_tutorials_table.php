<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTutorialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasTable('tutorials')) {
            Schema::create('tutorials', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('slug')->nullable();
                $table->text('description')->nullable();
                $table->text('content')->nullable();
                $table->decimal('price', 15, 2)->nullable();
                $table->string('image_id')->nullable();
                $table->integer('featured')->default(0)->nullable();
                $table->integer('trending')->default(0)->nullable();
                $table->integer('popular')->default(0)->nullable();
                $table->string('time')->nullable();
                $table->text('meta_title')->nullable();
                $table->text('meta_description')->nullable();
                $table->text('meta_keywords')->nullable();

                $table->tinyInteger('published')->nullable()->default(0);
                $table->tinyInteger('free')->default(0)->nullable();
                $table->timestamps();
                $table->softDeletes();

                $table->index(['deleted_at']);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tutorials');
    }
}
