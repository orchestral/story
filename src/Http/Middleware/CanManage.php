<?php namespace Orchestra\Story\Http\Middleware;

use Closure;
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
     * Create a new middleware instance.
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
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $action
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $action = null)
    {
        list($action, $type) = explode('-', $action);

        if (! $this->authorize($action, $type)) {
            return redirect(handles("orchestra::storycms/{$type}s"));
        }

        return $next($request);
    }

    /**
     * Can the user take this action.
     *
     * @param  string  $action
     * @param  string  $type
     *
     * @return bool
     */
    protected function authorize($action, $type)
    {
        $acl = $this->acl;

        return ($acl->can("{$action} {$type}") || $acl->can("manage {$type}"));
    }
}
