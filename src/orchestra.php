<?php

use Orchestra\Support\Facades\Acl;
use Orchestra\Support\Facades\App;
use Orchestra\Support\Facades\Config;

Acl::make('orchestra/story')->attach(App::memory());

Config::map('orchestra/story', array(
	'default_format' => 'orchestra/story::default_format',
	'default_page'   => 'orchestra/story::default_page',
	'per_page'       => 'orchestra/story::per_page',
	'page_permalink' => 'orchestra/story::permalink.page',
	'post_permalink' => 'orchestra/story::permalink.post',
));

include __DIR__.'/start/events.php';
include __DIR__.'/routes.php';
