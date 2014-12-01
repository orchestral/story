<?php namespace Orchestra\Story;

use Orchestra\Contracts\Auth\Guard;
use Orchestra\Contracts\Foundation\Foundation;

class StoryMenuHandler
{
    /**
     * ACL instance.
     *
     * @var \Orchestra\Contracts\Auth\Guard
     */
    protected $auth;

    /**
     * Menu instance.
     *
     * @var \Orchestra\Widget\Handlers\Menu
     */
    protected $menu;

    /**
     * Construct a new handler.
     *
     * @param  \Orchestra\Contracts\Foundation\Foundation  $foundation
     * @param  \Orchestra\Contracts\Auth\Guard  $auth
     */
    public function __construct(Foundation $foundation, Guard $auth)
    {
        $this->menu = $foundation->menu();
        $this->auth = $auth;
    }

    /**
     * Create a handler for `orchestra.ready: admin` event.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->auth->guest()) {
            return ;
        }

        $this->menu->add('storycms', '^:extensions')
            ->title('Story CMS')
            ->link(handles('orchestra::storycms'));
    }
}
