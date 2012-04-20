<!-- this is our blade template file
	other views will use this as a "wrapper" -->

<!DOCTYPE HTML>
<html lang="en-GB">
<head>
	<meta charset="UTF-8">
	<title>@yield('title')</title>
	{{ HTML::style('css/style.css') }}
</head>
<body>
	<div class="header">
		@if ( Auth::guest() )
			{{ HTML::link('admin', 'Login') }}
		@else
			{{ HTML::link('logout', 'Logout') }}
		@endif
		<hr />
		<h1>Wordpush</h1>
		<h2>Code is Limmericks</h2>
	</div>

	<div class="content">
		@yield('content')
	</div>
</body>
</html>