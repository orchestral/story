<?php

namespace spec\Orchestra\Story\Http\Handlers;

use Illuminate\Contracts\Container\Container;
use Orchestra\Contracts\Auth\Guard;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StoryMenuHandlerSpec extends ObjectBehavior
{
    function let(Container $app)
    {
        $this->beConstructedWith($app);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Orchestra\Story\Http\Handlers\StoryMenuHandler');
        $this->shouldHaveType('Orchestra\Foundation\Support\MenuHandler');
    }

    function it_cannot_be_authorized_when_given_guest(Guard $auth)
    {
        $auth->guest()->shouldBeCalled(1)->willReturn(true);

        $this->authorize($auth)->shouldReturn(false);
    }

    function it_can_be_authorized_when_given_user(Guard $auth)
    {
        $auth->guest()->shouldBeCalled(1)->willReturn(false);

        $this->authorize($auth)->shouldReturn(true);
    }
}
