<?php

class Create_Posts {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		// create our posts table
		Schema::create('posts', function($table) {
			$table->increments('id');
			$table->string('title', 128);
			$table->text('body');
			$table->integer('author_id');
			$table->timestamps();
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		// drop our posts table
		Schema::drop('posts');
	}

}