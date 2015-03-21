<?php

namespace spec\Orchestra\Story\Parsers;

use Illuminate\Contracts\Container\Container;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MarkdownSpec extends ObjectBehavior
{
    function let(Container $app)
    {
        $this->beConstructedWith($app);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Orchestra\Story\Parsers\Markdown');
    }

    function it_should_parse_markdown_syntax()
    {
        $this->parse('foo **bar**')->shouldReturn('<p>foo <strong>bar</strong></p>');
    }

    function it_should_parse_html_syntax()
    {
        $this->parse('foo <strong>bar</strong>')->shouldReturn('<p>foo <strong>bar</strong></p>');
    }
}
