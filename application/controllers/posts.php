<?php

class Posts_Controller extends Base_Controller
{
	public function action_index()
	{
		// lets get our posts and eager load the
		// author
		$posts = Post::with('author')->all();

		// show the home view, and include our
		// posts too
		return View::make('posts.index')
			->with('posts', $posts);
	}

	public function action_show($post_id)
	{
		// get our post, identified by the route
		// parameter
		$post = Post::find($post_id);

		// show the full view, and pass the post
		// we just aquired
		return View::make('posts.show')
			->with('post', $post);
	}

	public function action_new()
	{
		// get the current user
		$user = Auth::user();

		// show the create post form, and send
		// the current user to identify the post author
		return View::make('posts.new')->with('user', $user);
	}

	public function action_create()
	{
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
			return Redirect::to('posts/new')
					->with('user', Auth::user())
					->with_errors($v)
					->with_input();
		}

		// create the new post
		$post = new Post($new_post);
		$post->save();

		// redirect to viewing our new post
		return Redirect::to('posts/'.$post->id);
	}
}
