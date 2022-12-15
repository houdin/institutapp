<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solutions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('color')->nullable();
            $table->softDeletes();
        });



        Schema::create('project_solution', function (Blueprint $table) {
            // $table->integer('permission_id')->unsigned();
            // $table->integer('role_id')->unsigned();


            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('solution_id')->constrained()->onDelete('cascade');
            $table->boolean('complete')->default(false);
            $table->date('completed_date')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->primary(['solution_id', 'project_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('project_solution');
        Schema::dropIfExists('solutions');
    }
};
