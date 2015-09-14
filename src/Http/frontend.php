<?php

$router->get('rss', 'HomeController@rss');
$router->get('posts', 'HomeController@posts');

$router->get(config('orchestra/story::permalink.page'), 'PostController@show')->where('{slug}', '(^[posts|rss])');
$router->get(config('orchestra/story::permalink.post'), 'PageController@show')->where('{slug}', '(^[posts|rss])');

$router->get('/', 'HomeController@index');
