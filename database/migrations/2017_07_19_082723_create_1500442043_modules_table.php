<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create1500442043ModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('modules')) {
            Schema::create('modules', function (Blueprint $table) {
                $table->id();
                // $table->integer('formation_id')->unsigned()->nullable();
                $table->foreignId('formation_id')->nullable()->constrained('formations')->onDelete('cascade');
                $table->string('title')->nullable();
                $table->string('slug')->nullable();
                $table->string('module_image')->nullable();
                $table->text('short_text')->nullable();
                $table->text('full_text')->nullable();
                $table->integer('position')->nullable()->unsigned();
                $table->tinyInteger('free_module')->nullable()->default(1);
                $table->tinyInteger('published')->nullable()->default(0);

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
        Schema::dropIfExists('modules');
    }
}
