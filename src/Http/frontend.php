<?php

$router->get('rss', 'HomeController@rss');
$router->get('posts', 'HomeController@posts');

$router->get(config('orchestra/story::permalink.post'), 'PostController@show')->where('{slug}', '(^[posts|rss])');
$router->get(config('orchestra/story::permalink.page'), 'PageController@show')->where('{slug}', '(^[posts|rss])');

$router->get('/', 'HomeController@index');
