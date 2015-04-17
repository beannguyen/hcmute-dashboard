<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$this->call('UserTableSeeder');
	}

}

class UserTableSeeder extends Seeder {

	public function run()
	{
		DB::table('users')->delete();

		\App\User::create(['email' => 'beanchanel@gmail.com', 'password' => '$2y$10$KpmVkvWHHiqlq4xKJMTMMew8vUWK.Aagjr9vh2renAqvA9hdpL5Me', 'name' => 'Bean Nguyen', 'active' => 1]);
	}

}
