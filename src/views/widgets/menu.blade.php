@section('orchestra/story::primary_menu')

<ul class="nav navbar-nav">
	<li class="{!! app('request')->is('*resources/storycms.posts*') ? 'active' : '' !!}">
		<a href="{!! resources('storycms.posts') !!}">Posts</a>
	</li>
	<li class="{!! app('request')->is('*resources/storycms.pages*') ? 'active' : '' !!}">
		<a href="{!! resources('storycms.pages') !!}">Pages</a>
	</li>
</ul>
<ul class="nav navbar-nav pull-right">
	<li>
		<a href="{!! handles('orchestra/story::/') !!}" target="_blank">View Website</a>
	</li>
</ul>
@stop

<?php

$navbar = new \Illuminate\Support\Fluent([
	'id'    => 'story',
	'title' => 'Story CMS',
	'url'   => resources('storycms'),
	'menu'  => app('view')->yieldContent('orchestra/story::primary_menu'),
]); ?>

@decorator('navbar', $navbar)

<br>
