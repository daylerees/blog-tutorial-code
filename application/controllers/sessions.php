<?php

class Sessions_Controller extends Base_Controller
{
	public function action_new()
	{
		// display the view with the login form
		return View::make('sessions.new');
	}

	public function action_create()
	{
		// get the username and password from the POST
		// data using the Input class
		$username = Input::get('username');
		$password = Input::get('password');

		// call Auth::attempt() on the username and password
		// to try to login, the session will be created
		// automatically on success
		if ( Auth::attempt($username, $password) )
		{
			// it worked, redirect to the admin route
			return Redirect::to('posts/new');
		}
		else
		{
			// login failed, show the form again and
			// use the login_errors data to show that
			// an error occured
			return Redirect::to('login')
				->with('login_errors', true);
		}
	}

	public function action_destroy()
	{
		// call the logout method to destroy
		// the login session
		Auth::logout();

		// redirect back to the home page
		return Redirect::to('/');
	}
}
