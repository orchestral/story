<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Orchestra\Support\Facades\Resources;

/*
|--------------------------------------------------------------------------
| Backend Routing
|--------------------------------------------------------------------------
*/

Event::listen('orchestra.started: admin', function () {
    $story = Resources::make('storycms', [
        'name'    => 'Story CMS',
        'uses'    => 'restful:Orchestra\Story\Routing\Admin\HomeController',
        'visible' => Auth::check(),
    ]);

    $story['posts'] = 'resource:Orchestra\Story\Routing\Admin\PostsController';
    $story['pages'] = 'resource:Orchestra\Story\Routing\Admin\PagesController';
});
