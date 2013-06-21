<?php namespace Orchestra\Story;

use Illuminate\Support\Manager;

class FormatManager extends Manager {

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
