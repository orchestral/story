<?php namespace Orchestra\Story;

use Illuminate\Support\Manager;
use Orchestra\Support\Str;

class FormatManager extends Manager {

	/**
	 * List of available parsers.
	 *
	 * @var array
	 */
	protected $parsers = array(
		'plain'    => 'Plain Text',
		'markdown' => 'Markdown',
	);

	/**
	 * Create an instance of the plain-text driver.
	 *
	 * @return \Orchestra\Story\Parsers\Plain
	 */
	public function createPlainDriver()
	{
		return new Parsers\Plain($this->app);
	}

	/**
	 * Create an instance of the Markdown driver.
	 *
	 * @return \Orchestra\Story\Parsers\Markdown
	 */
	public function createMarkdownDriver()
	{		
		return new Parsers\Markdown($this->app);
	}

	/**
	 * Register a custom driver creator Closure.
	 *
	 * @param  string   $name
	 * @param  Closure  $callback
	 * @return void
	 */
	public function extend($name, Closure $callback)
	{
		$this->parsers[$driver = Str::camel($name)] = $name;

		return parent::extend($driver, $callback);
	}

	/**
	 * Get list of parsers.
	 *
	 * @access public
	 * @return array
	 */
	public function getParsers()
	{
		return $this->parsers;
	}

	/**
	 * Get available parser, or use the default.
	 *
	 * @access public
	 * @param  string   $name
	 * @return string
	 */
	public function get($name)
	{
		if (in_array($name, $this->getParsers())) return $name;

		return $this->getDefaultDriver();
	}

	/**
	 * Create Default driver.
	 * 
	 * @access protected
	 * @param  string   $name
	 * @return string
	 */
	protected function getDefaultDriver()
	{
		return $this->app['config']->get('orchestra/story::format', 'markdown');
	}
}
