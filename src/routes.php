<?php

use Illuminate\Support\Facades\Route;
use Orchestra\Support\Facades\App;

Route::group(array('prefix' => App::route('orchestra/story', 'cms')), function ()
{
	Route::get('/', 'Orchestra\Story\Routing\HomeController@getIndex');
});
