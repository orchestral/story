<?php namespace Orchestra\Story\Parsers\TestCase;

use Illuminate\Container\Container;
use Orchestra\Story\Parsers\Plain;

class PlainTest extends \PHPUnit_Framework_TestCase {
	
	/**
	 * Data provider for parsing.
	 *
	 * @return array
	 */
	public function getParsingDataProvider()
	{
		return array(
			array('foo **bar**', 'foo **bar**'),
			array('foo <strong>bar</strong>', 'foo <strong>bar</strong>'),
		);
	}

	/**
	 * Test Orchestra\Story\Parsers\Plain::parse() method.
	 *
	 * @dataProvider getParsingDataProvider
	 * @test
	 */
	public function testParseMethod($expected, $output)
	{
		$app  = new Container;
		$stub = new Plain($app);

		$this->assertEquals($expected, $stub->parse($output));
	}
}
