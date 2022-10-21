<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBundleFormationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('bundle_formations')) {

            Schema::create('bundle_formations', function (Blueprint $table) {
                // $table->integer('bundle_id')->unsigned();
                $table->foreignId('bundle_id')->constrained('bundles')->onDelete('cascade');
                // $table->integer('formation_id')->unsigned();
                $table->foreignId('formation_id')->constrained('formations')->onDelete('cascade');
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
        Schema::dropIfExists('bundle_formations');
    }
}
