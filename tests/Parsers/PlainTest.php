<?php namespace Orchestra\Story\Parsers\TestCase;

use Mockery as m;
use Orchestra\Story\Parsers\Plain;
use Illuminate\Container\Container;
use Orchestra\Story\Parsers\Parser;

class PlainTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testItIsInitializable()
    {
        $app = new Container();

        $stub = new Plain($app);

        $this->assertInstanceOf(Plain::class, $stub);
        $this->assertInstanceOf(Parser::class, $stub);
    }

    /**
     * @dataProvider parseDataProvider
     */
    public function testItIgnoreSpecialSyntax($given)
    {
        $app = new Container();

        $stub = new Plain($app);

        $this->assertEquals($given, $stub->parse($given));
    }

    public function parseDataProvider()
    {
        return [
            ['foo **bar**'],
            ['foo <strong>bar</strong>']
        ];
    }
}
