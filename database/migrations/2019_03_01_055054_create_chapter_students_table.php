<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChapterStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chapter_students', function (Blueprint $table) {
            $table->id();
            $table->nullableMorphs('model');
            // $table->integer('user_id')->unsigned()->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            // $table->integer('formation_id')->unsigned()->nullable();
            $table->foreignId('formation_id')->nullable()->constrained('formations')->onDelete('cascade');
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
        Schema::dropIfExists('chapter_students');
    }
}
