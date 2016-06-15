<?php

namespace Orchestra\Control\Http\Handlers;

use Orchestra\Contracts\Auth\Guard;
use Orchestra\Foundation\Support\MenuHandler;

class PostMenuHandler extends MenuHandler
{
    /**
     * Menu configuration.
     *
     * @var array
     */
    protected $menu = [
        'id'    => 'storycms-posts',
        'title' => 'Posts',
        'link'  => 'orchestra::storycms/posts',
        'icon'  => null,
    ];

    /**
     * Check whether the menu should be displayed.
     *
     * @param  \Orchestra\Contracts\Auth\Guard  $auth
     *
     * @return bool
     */
    public function authorize(Guard $auth)
    {
        return ! $auth->guest();
    }
}
