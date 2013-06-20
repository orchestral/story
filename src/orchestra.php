<?php

use Illuminate\Support\Facades\Event;
use Orchestra\Support\Facades\Acl;
use Orchestra\Support\Facades\App;
use Orchestra\Support\Facades\Config;

Acl::make('orchestra/story')->attach(App::memory());

Config::map('orchestra/story', array(
	'page_permalink' => 'orchestra/story::permalink.page',
	'post_permalink' => 'orchestra/story::permalink.post',
));

Event::listen('orchestra.ready: admin', 'Orchestra\Story\Services\Events\DashboardHandler@onDashboardView');
Event::listen('orchestra.form: extension.orchestra/story', 'Orchestra\Story\Services\Events\ExtensionHandler@onFormView');
