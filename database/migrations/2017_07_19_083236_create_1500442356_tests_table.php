<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create1500442356TestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tests')) {
            Schema::create('tests', function (Blueprint $table) {
                $table->id();
                // $table->integer('formation_id')->unsigned()->nullable();
                $table->foreignId('formation_id')->nullable()->constrained('formations')->onDelete('cascade');
                // $table->integer('module_id')->unsigned()->nullable();
                $table->foreignId('module_id')->nullable()->constrained('modules')->onDelete('cascade');
                $table->string('title')->nullable();
                $table->text('description')->nullable();
                $table->tinyInteger('published')->nullable()->default(0);
                $table->string('slug')->nullable();
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
        Schema::dropIfExists('tests');
    }
}
