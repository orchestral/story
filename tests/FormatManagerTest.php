<?php namespace Orchestra\Story\TestCase;

use Mockery as m;
use Illuminate\Container\Container;
use Orchestra\Story\FormatManager;
use Orchestra\Story\Parsers\Markdown;

class FormatManagerTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Application instance.
	 *
	 * @var \Illuminate\Foundation\Application
	 */
	protected $app = null;

	/**
	 * Setup the test environment.
	 */
	public function setUp()
	{
		$this->app = new Container;
	}

	/**
	 * Teardown the test environment.
	 */
	public function tearDown()
	{
		unset($this->app);
		m::close();
	}

	/**
	 * Test Orchestra\Story\Format::driver() methods.
	 */
	public function testDriversMethod()
	{
		$app = $this->app;
		$app['config'] = $config = m::mock('\Illuminate\Config\Repository');

		$config->shouldReceive('get')->twice()
			->with('orchestra/story::config.default_format', 'markdown')->andReturn('markdown');

		$stub = new FormatManager($app);

		$this->assertInstanceOf('\Orchestra\Story\Parsers\Markdown', $stub->driver());
		$this->assertInstanceOf('\Orchestra\Story\Parsers\Plain', $stub->driver('plain'));
		$this->assertEquals('markdown', $stub->get('foo'));
		$this->assertEquals('plain', $stub->get('plain'));
	}

	/**
	 * Test Orchestra\Story\Format::extend() method.
	 */
	public function testExtendMethod()
	{
		$app = $this->app;
		$stub = new FormatManager($app);

		$stub->extend('markup', function () use ($app)
		{
			return new Markdown($app);
		});

		$this->assertInstanceOf('\Orchestra\Story\Parsers\Markdown', $stub->driver('markup'));
		$this->assertEquals('markup', $stub->get('markup'));
	}
}
