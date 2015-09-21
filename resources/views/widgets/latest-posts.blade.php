<div class="box white rounded list-group no-padding">
	@foreach($posts as $post)
	<a href="{!! $post->url() !!}" class="list-group-item">{{ $post->title }}</a>
	@endforeach
</div>
