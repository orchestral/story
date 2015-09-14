<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => 'storycms'], function (Router $router) {
    $router->resource('pages', 'PagesController');
    $router->resource('posts', 'PostsController');
    $router->get('/', 'HomeController@show');
});
