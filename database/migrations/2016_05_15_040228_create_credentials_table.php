<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCredentialsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('credentials', function(Blueprint $table)
		{
			$table->id();
			$table->foreignId('user_id')->constrained();
			$table->foreignId('project_id')->constrained();			
			$table->boolean('type');
			$table->string('name');
			$table->string('hostname');
			$table->string('username');
			$table->string('password');
			$table->integer('port');
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
		Schema::dropIfExists('credentials');
	}

}
