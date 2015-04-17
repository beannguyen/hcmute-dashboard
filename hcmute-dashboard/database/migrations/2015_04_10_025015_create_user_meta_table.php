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
		Schema::create('usermeta', function(Blueprint $table)
		{
			//
			$table->increments('id');
			$table->integer('userid');
			$table->string('key', 255);
			$table->string('value', 255);

			$table->foreign('userid')->references('id')->on('users');
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
			Schema::drop('usermeta');
		});
	}

}
