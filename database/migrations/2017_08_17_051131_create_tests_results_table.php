<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestsResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tests_results', function (Blueprint $table) {
            $table->id();
            // $table->integer('test_id')->unsigned()->nullable();
            $table->foreignId('test_id')->constrained('tests')->onDelete('cascade');
            // $table->integer('user_id')->unsigned()->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('test_result');
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
        Schema::dropIfExists('tests_results');
    }
}
