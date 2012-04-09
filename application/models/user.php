<?php

class User extends Eloquent
{
	public function posts()
	{
		return $this->has_many('Post');
	}
}