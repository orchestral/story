@extends('orchestra/story::layout')

@section('content')
<section class="home">
	<h2>Recent Posts</h2>
	<ul class="archive">
	@foreach ($posts as $post)
		<li>
			<span>
				<i class="icon-calendar"></i><?php echo $post->published_at->format('M d, Y'); ?>
			</span>&nbsp;
			<strong>
				<a href="#"><?php echo $post['title']; ?></a>
			</strong>
		</li>
	@endforeach
	</ul>

	<?php echo $posts->links(); ?>
</section>
@stop
