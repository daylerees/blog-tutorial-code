@layout('templates.main')

@section('content')
	@foreach ($posts as $post)
		<div class="post">
			<h1>{{ HTML::link('posts/'.$post->id, $post->title) }}</h1>
			<p>{{ substr($post->body,0, 120).' [..]' }}</p>
			<p>{{ HTML::link('posts/'.$post->id, 'Read more &rarr;') }}</p>
		</div>
	@endforeach
@endsection
