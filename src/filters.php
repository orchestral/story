<?php

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Orchestra\Support\Facades\Acl;
use Orchestra\Story\Facades\StoryFormat;

Route::filter('orchestra.story.editor', function ($request, $route, $format = '')
{
	Event::fire("orchestra.story.editor: {$format}");
});

Route::filter('orchestra.story', function ($request, $route, $value = '')
{
	list($action, $type) = explode('-', $value);

	$acl = Acl::make('orchestra/story');

	if ( ! ($acl->can("{$action} {$type}") or $acl->can("manage {$type}")))
	{
		return Redirect::to(resources("storycms.{$type}s"));
	}
});
