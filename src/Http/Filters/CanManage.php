<?php namespace Orchestra\Story\Http\Filters;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Orchestra\Contracts\Foundation\Foundation;
use Orchestra\Contracts\Authorization\Factory;

class CanManage
{
    /**
     * The application implementation.
     *
     * @var \Orchestra\Contracts\Foundation\Foundation
     */
    protected $foundation;

    /**
     * The authorization factory implementation.
     *
     * @var \Orchestra\Contracts\Authorization\Authorization
     */
    protected $acl;

    /**
     * Create a new filter instance.
     *
     * @param  \Orchestra\Contracts\Foundation\Foundation  $foundation
     * @param  \Orchestra\Contracts\Authorization\Factory  $acl
     */
    public function __construct(Foundation $foundation, Factory $acl)
    {
        $this->acl        = $acl->make('orchestra/story');
        $this->foundation = $foundation;
    }

    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Routing\Route  $route
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $value
     *
     * @return mixed
     */
    public function filter(Route $route, Request $request, $value = '')
    {
        list($action, $type) = explode('-', $value);

        if (! $this->checkUserAuthorization($action, $type)) {
            return redirect(handles("orchestra::storycms/{$type}s"));
        }
    }

    /**
     * Can the user take this action.
     *``.
     *
     * @param  string  $action
     * @param  string  $type
     *
     * @return bool
     */
    protected function checkUserAuthorization($action, $type)
    {
        $acl = $this->acl;

        return ($acl->can("{$action} {$type}") || $acl->can("manage {$type}"));
    }
}
