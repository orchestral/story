<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Orchestra\Support\Facades\App;

/*
|--------------------------------------------------------------------------
| Frontend Routing
|--------------------------------------------------------------------------
*/

App::group('orchestra/story', 'cms', [], function () {
    $page = Config::get('orchestra/story::permalink.page');
    $post = Config::get('orchestra/story::permalink.post');

    Route::get('rss', 'Orchestra\Story\Routing\HomeController@rss');

    Route::get($post, 'Orchestra\Story\Routing\PostController@show')
        ->where('{slug}', '(^[posts|rss])');

    Route::get('posts', 'Orchestra\Story\Routing\HomeController@posts');

    Route::get($page, 'Orchestra\Story\Routing\PageController@show')
        ->where('{slug}', '(^[posts|rss])');

    Route::get('/', 'Orchestra\Story\Routing\HomeController@index');
});
