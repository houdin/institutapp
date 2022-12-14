<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBundlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasTable('bundles')) {

            Schema::create('bundles', function (Blueprint $table) {
                $table->id();
                // $table->integer('user_id')->unsigned()->nullable();
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
                $table->string('title');
                $table->string('slug')->nullable();
                $table->text('description')->nullable();
                $table->decimal('price', 15, 2)->nullable();
                $table->string('formation_image')->nullable();
                $table->date('start_date')->nullable();
                $table->integer('featured')->default(0)->nullable();
                $table->integer('trending')->default(0)->nullable();
                $table->integer('popular')->default(0)->nullable();
                $table->text('meta_title')->nullable();
                $table->longText('meta_description')->nullable();
                $table->longText('meta_keywords')->nullable();
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
        Schema::dropIfExists('bundles');
    }
}
