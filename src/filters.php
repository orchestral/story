<?php

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Orchestra\Story\Facades\StoryFormat;

Route::filter('orchestra.story.editor', function ($request, $route, $format = '')
{
	Event::fire("orchestra.story.editor: {$format}");
});
