<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->text('description')->nullable();
            $table->date('due_date')->nullable();
            $table->boolean('complete')->default(false);
            $table->date('completed_date')->nullable();
            $table->boolean('wish')->default(true);
            $table->string('production')->nullable();
            $table->string('stage')->nullable();
            $table->string('dev')->nullable();
            $table->string('github')->nullable();
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
        Schema::dropIfExists('projects');
    }
}
