<?php

namespace Orchestra\Story\Http\Middleware;

use Closure;
use Illuminate\Contracts\Events\Dispatcher;

class SetEditorFormat
{
    /**
     * The event dispatcher implementation.
     *
     * @var \Illuminate\Contracts\Events\Dispatcher
     */
    protected $dispatcher;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $dispatcher
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $format
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $format = null)
    {
        $this->dispatcher->fire("orchestra.story.editor: {$format}");

        return $next($request);
    }
}
