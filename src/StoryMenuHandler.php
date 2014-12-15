<?php namespace Orchestra\Story;

use Orchestra\Contracts\Auth\Guard;
use Orchestra\Foundation\Support\MenuHandler;

class StoryMenuHandler extends MenuHandler
{
    /**
     * Get ID.
     *
     * @return string
     */
    protected function getId()
    {
        return 'storycms';
    }

    /**
     * Get position.
     *
     * @return string
     */
    protected function getPosition()
    {
        return $this->menu->has('extensions') ? '^:extensions' : '>:home';
    }

    /**
     * Get the title.
     *
     * @return string
     */
    protected function getTitle()
    {
        return 'Story CMS';
    }

    /**
     * Get the URL.
     *
     * @return string
     */
    protected function getLink()
    {
        return handles('orchestra::storycms');
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
