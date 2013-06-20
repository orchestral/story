<?php

use Illuminate\Support\Facades\Route;
use Orchestra\Support\Facades\App;

Route::group(array('prefix' => App::route('orchestra/story', 'cms')), function ()
{
	$page = Config::get('orchestra/story::permalink.page');
	$post = Config::get('orchestra/story::permalink.post');

	Route::get($post, 'Orchestra\Story\Routing\PostController@show')
		->where('{slug}', '(^[posts|rss])');

	Route::get('posts', 'Orchestra\Story\Routing\HomeController@showPosts');

	Route::get($page, 'Orchestra\Story\Routing\PageController@show')
		->where('{slug}', '(^[posts|rss])');

	Route::get('/', 'Orchestra\Story\Routing\HomeController@index');
});
