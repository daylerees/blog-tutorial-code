@layout('templates.main')

@section('content')
	{{ Form::open('login') }}

		<!-- check for login errors flash var -->
		@if (Session::has('login_errors'))
			<span class="error">Username or password incorrect.</span>
		@endif

		<!-- username field -->
		<p>{{ Form::label('username', 'Username') }}</p>
		<p>{{ Form::text('username') }}</p>

		<!-- password field -->
		<p>{{ Form::label('password', 'Password') }}</p>
		<p>{{ Form::text('password') }}</p>

		<!-- submit button -->
		<p>{{ Form::submit('Login') }}</p>

	{{ Form::close() }}
@endsection