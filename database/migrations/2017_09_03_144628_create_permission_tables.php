<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableNames = config('permission.table_names');

        Schema::create($tableNames['permissions'], function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('guard_name');
            $table->string('ref');
            $table->timestamps();
        });

        Schema::create($tableNames['roles'], function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('guard_name');
            $table->string('ref');
            $table->timestamps();
        });

        Schema::create($tableNames['model_has_permissions'], function (Blueprint $table) use ($tableNames) {
            // $table->integer('permission_id')->unsigned();
            $table->foreignId('permission_id')
                // ->references('id')
                ->constrained($tableNames['permissions'])
                ->onDelete('cascade');
            $table->morphs('model');


            $table->primary(['permission_id', 'model_id', 'model_type']);
        });

        Schema::create($tableNames['model_has_roles'], function (Blueprint $table) use ($tableNames) {
            // $table->integer('role_id')->unsigned();
            $table->foreignId('role_id')
                // ->references('id')
                ->constrained($tableNames['roles'])
                ->onDelete('cascade');
            $table->morphs('model');


            $table->primary(['role_id', 'model_id', 'model_type']);
        });

        Schema::create($tableNames['role_has_permissions'], function (Blueprint $table) use ($tableNames) {
            // $table->integer('permission_id')->unsigned();
            // $table->integer('role_id')->unsigned();

            $table->foreignId('permission_id')
                // ->references('id')
                ->constrained($tableNames['permissions'])
                ->onDelete('cascade');

            $table->foreignId('role_id')
                // ->references('id')
                ->constrained($tableNames['roles'])
                ->onDelete('cascade');

            $table->primary(['permission_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tableNames = config('permission.table_names');

        Schema::drop($tableNames['role_has_permissions']);
        Schema::drop($tableNames['model_has_roles']);
        Schema::drop($tableNames['model_has_permissions']);
        Schema::drop($tableNames['roles']);
        Schema::drop($tableNames['permissions']);
    }
}
