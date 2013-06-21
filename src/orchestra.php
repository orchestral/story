<?php

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;
use Orchestra\Support\Facades\Acl;
use Orchestra\Support\Facades\App;
use Orchestra\Support\Facades\Config;
use Orchestra\Support\Facades\Widget;

Acl::make('orchestra/story')->attach(App::memory());

Config::map('orchestra/story', array(
	'default_page'   => 'orchestra/story::default_page',
	'per_page'       => 'orchestra/story::per_page',
	'page_permalink' => 'orchestra/story::permalink.page',
	'post_permalink' => 'orchestra/story::permalink.post',
));

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

include __DIR__.'/routes.php';
