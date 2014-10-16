<?php

use Illuminate\Support\Facades\Config;
use Orchestra\Support\Facades\Foundation;

/*
|--------------------------------------------------------------------------
| Frontend Routing
|--------------------------------------------------------------------------
*/

Foundation::group('orchestra/story', 'cms', [], function ($router) {
    $page = Config::get('orchestra/story::permalink.page');
    $post = Config::get('orchestra/story::permalink.post');

    $router->get('rss', 'Orchestra\Story\Routing\HomeController@rss');

    $router->get($post, 'Orchestra\Story\Routing\PostController@show')
        ->where('{slug}', '(^[posts|rss])');

    $router->get('posts', 'Orchestra\Story\Routing\HomeController@posts');

    $router->get($page, 'Orchestra\Story\Routing\PageController@show')
        ->where('{slug}', '(^[posts|rss])');

    $router->get('/', 'Orchestra\Story\Routing\HomeController@index');
});
