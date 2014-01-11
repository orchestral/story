@extends('orchestra/story::layout')

@section('content')
<section class="home">
	<h2>Recent Posts</h2>
	<ul class="archive">
	@foreach ($posts as $post)
		<li>
			<span>
				<i class="icon-calendar"></i>{{ $post->published_at->format('M d, Y') }}
			</span>&nbsp;
			<strong>
				<a href="{{ $post->link }}">{{ $post->title }}</a>
			</strong>
		</li>
	@endforeach
	</ul>

	{{ $posts->links() }}
</section>
@stop
