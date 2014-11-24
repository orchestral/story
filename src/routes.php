<?php

use Illuminate\Routing\Router;
use Orchestra\Support\Facades\Foundation;

/*
|--------------------------------------------------------------------------
| Frontend Routing
|--------------------------------------------------------------------------
*/

Foundation::group('orchestra/story', 'cms', ['namespace' => 'Orchestra\Story\Routing'], function (Router $router) {
    $page = config('orchestra/story::permalink.page');
    $post = config('orchestra/story::permalink.post');

    $router->get('rss', 'HomeController@rss');
    $router->get('posts', 'HomeController@posts');

    $router->get($post, 'PostController@show')->where('{slug}', '(^[posts|rss])');
    $router->get($page, 'PageController@show')->where('{slug}', '(^[posts|rss])');

    $router->get('/', 'HomeController@index');
});
