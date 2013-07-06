@section('orchestra/story::primary_menu')

<?php

use Illuminate\Support\Facades\HTML;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Fluent;
use Orchestra\Support\Facades\App; ?>

<ul class="nav navbar-nav">
	<li class="<?php echo Request::is('*/resources/storycms.posts*') ? 'active' : ''; ?>">
		<a href="<?php echo resources('storycms.posts'); ?>">Posts</a>
	</li>
	<li class="<?php echo Request::is('*/resources/storycms.pages*') ? 'active' : ''; ?>">
		<a href="<?php echo resources('storycms.pages'); ?>">Pages</a>
	</li>
</ul>
<ul class="nav navbar-nav pull-right">
	<li>
		<a href="<?php echo handles('orchestra/story::/'); ?>" target="_blank">View Website</a>
	</li>
</ul>
@stop

<?php

$navbar = new Fluent(array(
	'id'    => 'story',
	'title' => 'Story CMS',
	'url'   => resources('storycms'),
	'menu'  => View::yieldContent('orchestra/story::primary_menu'),
)); ?>

@decorator('navbar', $navbar)

<br>
