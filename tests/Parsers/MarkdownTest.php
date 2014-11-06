<?php namespace Orchestra\Story\Parsers\TestCase;

use Illuminate\Container\Container;
use Orchestra\Story\Parsers\Markdown;

class MarkdownTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Data provider for parsing.
     *
     * @return array
     */
    public function getParsingDataProvider()
    {
        return array(
            array("<p>foo <strong>bar</strong></p>", 'foo **bar**'),
            array("<p>foo <strong>bar</strong></p>", 'foo <strong>bar</strong>'),
        );
    }

    /**
     * Test Orchestra\Story\Parsers\Markdown::parse() method.
     *
     * @dataProvider getParsingDataProvider
     * @test
     */
    public function testParseMethod($expected, $output)
    {
        $app  = new Container;
        $stub = new Markdown($app);

        $this->assertEquals($expected, $stub->parse($output));
    }
}
