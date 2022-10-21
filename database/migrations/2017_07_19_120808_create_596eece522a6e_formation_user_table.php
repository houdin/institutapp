<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create596eece522a6eFormationUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('formation_user')) {
            Schema::create('formation_user', function (Blueprint $table) {
                $table->foreignId('formation_id')->constrained()->onDelete('cascade');
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                // $table->integer('formation_id')->unsigned()->nullable();
                // $table->foreign('formation_id', 'fk_p_54418_54417_user_cou_596eece522b73')->references('id')->on('formations')->onDelete('cascade');
                // $table->integer('user_id')->unsigned()->nullable();
                // $table->foreign('user_id', 'fk_p_54417_54418_formation_u_596eece522bee')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('formation_user');
    }
}
