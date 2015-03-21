<?php

namespace spec\Orchestra\Story\Http\Filters;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SetEditorFormatSpec extends ObjectBehavior
{
    function let(Dispatcher $events)
    {
        $this->beConstructedWith($events);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Orchestra\Story\Http\Filters\SetEditorFormat');
    }

    public function it_should_dispatch_an_event(Dispatcher $events, Route $route, Request $request)
    {
        $events->fire('orchestra.story.editor: html')->shouldBeCalled(1)->willReturn(null);

        $this->beConstructedWith($events);

        $this->filter($route, $request, 'html')->shouldReturn(null);
    }
}
