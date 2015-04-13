<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserMetaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_meta', function(Blueprint $table)
		{
			//
			$table->increments('id');
			$table->integer('user_id');
			$table->string('key', 255);
			$table->string('value', 255);

			$table->foreign('user_id')->references('id')->on('users');
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
		Schema::table('user_meta', function(Blueprint $table)
		{
			//
			Schema::drop('user_meta');
		});
	}

}
