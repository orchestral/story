<?php

namespace Orchestra\Story\Http\Handlers;

use Orchestra\Contracts\Auth\Guard;
use Orchestra\Foundation\Support\MenuHandler;

class StoryMenuHandler extends MenuHandler
{
    /**
     * Menu configuration.
     *
     * @var array
     */
    protected $menu = [
        'id'    => 'storycms',
        'title' => 'Story CMS',
        'link'  => '#!',
        'icon'  => 'book',
        'with'  => [
            PostMenuHandler::class,
            PageMenuHandler::class,
        ],
    ];

    /**
     * Get position.
     *
     * @return string
     */
    public function getPositionAttribute()
    {
        return $this->handler->has('extensions') ? '>:extensions' : '>:home';
    }

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
