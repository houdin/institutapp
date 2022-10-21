<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBundleStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('bundle_student')) {
            Schema::create('bundle_student', function (Blueprint $table) {
                // $table->integer('bundle_id')->unsigned()->nullable();
                $table->foreignId('bundle_id')->constrained('bundles')->onDelete('cascade');
                // $table->integer('user_id')->unsigned()->nullable();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->integer('rating')->unsigned()->default(0);
                $table->timestamps();
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
        Schema::dropIfExists('bundle_student');
    }
}
