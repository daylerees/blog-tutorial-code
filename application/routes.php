<?php


/*
|--------------------------------------------------------------------------
| VIEW ALL POSTS PAGE
|--------------------------------------------------------------------------
*/

Route::get('/', function() {

	// lets get our posts and eager load the
	// author
	$posts = Post::with('author')->all();

	// show the home view, and include our
	// posts too
	return View::make('pages.home')
		->with('posts', $posts);

});

/*
|--------------------------------------------------------------------------
| VIEW A SINGLE POST PAGE
|--------------------------------------------------------------------------
*/

Route::get('view/(:num)', function($post) {

	// get our post, identified by the route
	// parameter
	$post = Post::find($post);

	// show the full view, and pass the post
	// we just aquired
	return View::make('pages.full')
		->with('post', $post);

});

/*
|--------------------------------------------------------------------------
| SHOW THE CREATE POST FORM
|--------------------------------------------------------------------------
*/

Route::get('admin', array('before' => 'auth', 'do' => function() {

	// get the current user
	$user = Auth::user();

	// show the create post form, and send
	// the current user to identify the post author
	return View::make('pages.new')->with('user', $user);

}));

/*
|--------------------------------------------------------------------------
| HANDLE THE CREATE POST FORM
|--------------------------------------------------------------------------
*/

Route::post('admin', array('before' => 'auth', 'do' => function() {

	// let's get the new post from the POST data
	// this is much safer than using mass assignment
	$new_post = array(
		'title' 	=> Input::get('title'),
		'body' 		=> Input::get('body'),
		'author_id' => Input::get('author_id')
	);

	// let's setup some rules for our new data
	// I'm sure you can come up with better ones
	$rules = array(
		'title' 	=> 'required|min:3|max:128',
		'body' 		=> 'required'		
	);

	// make the validator
	$v = Validator::make($new_post, $rules);

	if ( $v->fails() )
	{
		// redirect back to the form with
		// errors, input and our currently
		// logged in user
		return Redirect::to('admin')
				->with('user', Auth::user())
				->with_errors($v)
				->with_input();
	}

	// create the new post
	$post = new Post($new_post);
	$post->save();

	// redirect to viewing our new post
	return Redirect::to('view/'.$post->id);

}));

/*
|--------------------------------------------------------------------------
| SHOW THE LOGIN FORM
|--------------------------------------------------------------------------
*/

Route::get('login', function() {

	// display the view with the login form
	return View::make('pages.login');

});

/*
|--------------------------------------------------------------------------
| HANDLE THE THE LOGIN FORM
|--------------------------------------------------------------------------
*/

Route::post('login', function() {

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
		return Redirect::to('admin');
	}
	else
	{
		// login failed, show the form again and
		// use the login_errors data to show that
		// an error occured
		return Redirect::to('login')
			->with('login_errors', true);
	}

});

/*
|--------------------------------------------------------------------------
| LOGOUT FROM THE SYSTEM
|--------------------------------------------------------------------------
*/


Route::get('logout', function() {

	// call the logout method to destroy
	// the login session
	Auth::logout();

	// redirect back to the home page
	return Redirect::to('/');
	
});

/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application.
|
*/

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in "before" and "after" filters are called before and
| after every request to your application, and you may even create other
| filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Router::register('GET /', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

Route::filter('before', function()
{
	// Do stuff before every request to your application...
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::to('login');
});