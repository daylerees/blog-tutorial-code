<?php

class Create_Users {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{

		// create our users table
		Schema::create('users', function($table) {
			$table->increments('id');
			$table->string('username', 128);
			$table->string('nickname', 128);
			$table->string('password', 64);
			$table->timestamps();
		});

		// insert a default user
		DB::table('users')->insert(array(
			'username'	=> 'admin',
			'nickname'	=> 'Admin',
			'password'	=> Hash::make('password')
		));		
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		// drop the users table
		Schema::drop('users');
	}

}