<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create1500442247QuestionsOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('questions_options')) {
            Schema::create('questions_options', function (Blueprint $table) {
                $table->id();
                // $table->integer('question_id')->unsigned()->nullable();
                $table->foreignId('question_id')->nullable()->constrained('questions')->onDelete('cascade');
                $table->text('option_text');
                $table->tinyInteger('correct')->nullable()->default(0);

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
        Schema::dropIfExists('questions_options');
    }
}
