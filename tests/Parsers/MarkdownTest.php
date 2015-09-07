<?php namespace Orchestra\Story\Parsers\TestCase;

use Mockery as m;
use Illuminate\Container\Container;
use Orchestra\Story\Parsers\Parser;
use Orchestra\Story\Parsers\Markdown;

class MarkdownTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testItIsInitializable()
    {
        $app = new Container();

        $stub = new Markdown($app);

        $this->assertInstanceOf(Markdown::class, $stub);
        $this->assertInstanceOf(Parser::class, $stub);
    }

    public function testItCanParseMarkdownSyntax()
    {
        $app = new Container();

        $stub = new Markdown($app);

        $this->assertEquals('<p>foo <strong>bar</strong></p>', $stub->parse('foo **bar**'));
    }

    public function testItCanParseHtmlSyntax()
    {
        $app = new Container();

        $stub = new Markdown($app);

        $this->assertEquals('<p>foo <strong>bar</strong></p>', $stub->parse('foo <strong>bar</strong>'));
    }
}
