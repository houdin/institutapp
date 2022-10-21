<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create596eeef709839QuestionTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('question_test')) {
            Schema::create('question_test', function (Blueprint $table) {
                // $table->integer('question_id')->unsigned()->nullable();
                $table->foreignId('question_id')->constrained('questions')->onDelete('cascade');
                // $table->integer('test_id')->unsigned()->nullable();
                $table->foreignId('test_id')->constrained('tests')->onDelete('cascade');

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
        Schema::dropIfExists('question_test');
    }
}
