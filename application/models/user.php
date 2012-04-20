<?php

class User extends Eloquent
{

	// a user can have many posts

	// lets use the has_many relationship for this
	public function posts()
	{
		return $this->has_many('Post');
	}
}