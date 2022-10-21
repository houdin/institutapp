<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormationStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('formation_student')) {
            Schema::create('formation_student', function (Blueprint $table) {
                // $table->integer('formation_id')->unsigned()->nullable();
                $table->foreignId('formation_id')->constrained('formations')->onDelete('cascade');
                // $table->integer('user_id')->unsigned()->nullable();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->timestamps();
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
        Schema::dropIfExists('formation_student');
    }
}
