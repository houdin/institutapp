<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('solution_id')->constrained()->onDelete('cascade');
            $table->string('weight');
            $table->integer('priority')->comment('0 - low, 1 - enabled');;
            $table->string('due_date')->nullable();
            $table->boolean('complete')->default(false);
            $table->date('completed_date')->nullable();
            $table->boolean('wish')->default(true);
            $table->softDeletes();
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
        Schema::dropIfExists('tasks');
    }
}
