<?php

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;
use Orchestra\Support\Facades\Asset;
use Orchestra\Support\Facades\Widget;

Event::listen('orchestra.ready: admin', 'Orchestra\Story\Services\Events\DashboardHandler@onDashboardView');
Event::listen('orchestra.form: extension.orchestra/story', 'Orchestra\Story\Services\Events\ExtensionHandler@onFormView');
Event::listen('orchestra.form: extension.orchestra/story', function ()
{
	$placeholder = Widget::make('placeholder.orchestra.extensions');
	$placeholder->add('permalink')->value(View::make('orchestra/story::widgets.help'));
});

Event::listen('orchestra.validate: extension.orchestra/story', function (& $rules)
{
	$rules['page_permalink'] = array('required');
});

Event::listen('orchestra.story.editor: markdown', function ()
{
	$asset = Asset::container('orchestra/foundation::header');
	$asset->script('editor', 'packages/orchestra/story/vendor/editor/editor.js');
	$asset->style('editor', 'packages/orchestra/story/vendor/editor/editor.css');
	$asset->script('storycms.md', 'packages/orchestra/story/js/storycms.markdown.js', array('editor'));
});
