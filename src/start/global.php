<?php

use Orchestra\Support\Facades\ACL;
use Orchestra\Support\Facades\Config;
use Orchestra\Support\Facades\Foundation;

/*
|--------------------------------------------------------------------------
| Attach Memory to ACL
|--------------------------------------------------------------------------
*/

Acl::make('orchestra/story')->attach(Foundation::memory());

/*
|--------------------------------------------------------------------------
| Allow Configuration to be managed via Database
|--------------------------------------------------------------------------
*/

Config::map('orchestra/story', array(
    'default_format' => 'orchestra/story::config.default_format',
    'default_page'   => 'orchestra/story::config.default_page',
    'per_page'       => 'orchestra/story::config.per_page',
    'page_permalink' => 'orchestra/story::config.permalink.page',
    'post_permalink' => 'orchestra/story::config.permalink.post',
));
