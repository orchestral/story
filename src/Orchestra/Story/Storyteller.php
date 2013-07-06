<?php namespace Orchestra\Story;

use Orchestra\Story\Model\Content;

class Storyteller {

	/**
	 * Application instance.
	 *
	 * @var \Illuminate\Foundation\Application
	 */
	protected $app;

	/**
	 * Create a new instance of Storytelling.
	 *
	 * @access public
	 * @param  \Illuminate\Foundation\Application   $app
	 * @return void
	 */
	public function __construct($app)
	{
		$this->app = $app;
	}

	/**
	 * Generate URL.
	 *
	 * @access public
	 * @return string
	 */
	public function url($type, $content = null)
	{
		$type       = trim($type, '/');
		$predefined = array('posts', 'rss', 'archives');

		if (in_array($type, $predefined)) return handles("orchestra/story::{$type}");

		return $this->content($type, $content);
	}

	/**
	 * Generate URL by content.
	 *
	 * @access public
	 * @param  string  
	 */
	public function content($type, $content = null)
	{
		$config = $this->app['config']->get('orchestra/story::config');
		$format = $this->app['config']->get("orchestra/story::permalink.{$type}");
		
		if (is_null($format) or ! ($content instanceof Content)) 
		{
			return handles("orchestra/story::/");
		}
		
		$permalinks = array(
			'id'    => $content->id,
			'slug'  => $content->slug,
			'type'  => $content->type,
			'date'  => $content->published_at->format('Y-m-d'),
			'year'  => $content->published_at->format('Y'),
			'month' => $content->published_at->format('m'),
			'day'   => $content->published_at->format('d'),
		);

		foreach ($permalinks as $key => $value)
		{
			$format = str_replace('{'.$key.'}', $value, $format);
		}

		return handles("orchestra/story::{$format}");
	}
}
