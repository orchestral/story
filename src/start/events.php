<?php

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;
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
