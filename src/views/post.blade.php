@extends('orchestra/story::layout')

@section('content')
<section>
	<h2 class="title"><?php echo $page->title; ?></h2>
	<?php echo $page->body; ?>
</section>
@stop
