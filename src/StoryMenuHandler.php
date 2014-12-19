<?php namespace Orchestra\Story;

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
        'link'  => 'orchestra::storycms',
        'icon'  => null,
    ];

    /**
     * Get position.
     *
     * @return string
     */
    protected function getPosition()
    {
        return $this->handler->has('extensions') ? '^:extensions' : '>:home';
    }

    /**
     * Check whether the menu should be displayed.
     *
     * @param  \Orchestra\Contracts\Auth\Guard  $auth
     * @return bool
     */
    public function authorize(Guard $auth)
    {
        return ! $auth->guest();
    }
}
