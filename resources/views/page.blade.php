@extends('orchestra/story::layout')

@section('content')
<section>
	<h2 class="title">{!! $page->title !!}</h2>
	{!! $page->body !!}
</section>
@stop
