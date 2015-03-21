<?php

namespace spec\Orchestra\Story\Parsers;

use Illuminate\Contracts\Container\Container;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PlainSpec extends ObjectBehavior
{
    function let(Container $app)
    {
        $this->beConstructedWith($app);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Orchestra\Story\Parsers\Plain');
        $this->shouldHaveType('Orchestra\Story\Parsers\Parser');
    }

    function it_should_ignore_markdown_syntax()
    {
        $this->parse('foo **bar**')->shouldReturn('foo **bar**');
    }

    function it_should_ignore_html_syntax()
    {
        $this->parse('foo <strong>bar</strong>')->shouldReturn('foo <strong>bar</strong>');
    }
}
