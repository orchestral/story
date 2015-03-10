<?php namespace Orchestra\Story\Http\Filters;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
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
     * Create a new filter instance.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $dispatcher
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
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
        $this->dispatcher->fire("orchestra.story.editor: {$value}");
    }
}
