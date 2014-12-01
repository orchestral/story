<?php namespace Orchestra\Story;

use Orchestra\Contracts\Foundation\Foundation;

class StoryMenuHandler
{
    /**
     * ACL instance.
     *
     * @var \Orchestra\Contracts\Authorization\Authorization
     */
    protected $acl;
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
     */
    public function __construct(Foundation $foundation)
    {
        $this->menu = $foundation->menu();
        $this->acl = $foundation->acl();
    }
    /**
     * Create a handler for `orchestra.ready: admin` event.
     *
     * @return void
     */
    public function handle()
    {
        $this->menu->add('storycms', '^:extensions')
            ->title('Story CMS')
            ->link(handles('orchestra::storycms'));
    }
}
