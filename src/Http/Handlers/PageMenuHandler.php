<?php

namespace Orchestra\Control\Http\Handlers;

use Orchestra\Contracts\Auth\Guard;
use Orchestra\Foundation\Support\MenuHandler;

class PageMenuHandler extends MenuHandler
{
    /**
     * Menu configuration.
     *
     * @var array
     */
    protected $menu = [
        'id'    => 'storycms-pages',
        'title' => 'Pages',
        'link'  => 'orchestra::storycms/pages',
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
