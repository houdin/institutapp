<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'images',
            function (Blueprint $table) {
                // $table->id();
                // $table->string('path');
                // $table->string('thumbnail')->nullable();
                $table->id();
                $table->nullableMorphs('model');
                $table->string('name')->nullable();
                $table->text('url')->nullable();
                // $table->string('type')->nullable();
                $table->string('file_name')->nullable();
                $table->string('extension')->nullable();
                $table->json('colors')->nullable();
                $table->unsignedInteger('size')->nullable();
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
    }
}
