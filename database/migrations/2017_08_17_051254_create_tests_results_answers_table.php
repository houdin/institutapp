<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestsResultsAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tests_results_answers', function (Blueprint $table) {
            $table->id();
            // $table->integer('tests_result_id')->unsigned()->nullable();
            $table->foreignId('tests_result_id')->constrained('tests_results')->onDelete('cascade');
            // $table->integer('question_id')->unsigned()->nullable();
            $table->foreignId('question_id')->constrained('questions')->onDelete('cascade');
            // $table->integer('option_id')->unsigned()->nullable();
            $table->foreignId('option_id')->constrained('questions_options')->onDelete('cascade');
            $table->tinyInteger('correct')->default(0);
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
        Schema::dropIfExists('tests_results_answers');
    }
}
