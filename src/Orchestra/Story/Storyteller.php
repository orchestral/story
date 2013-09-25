<?php namespace Orchestra\Story;

use Carbon\Carbon;
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
	 * @return string
	 */
	public function url($type, $content = null)
	{
		$type       = trim($type, '/');
		$predefined = array('posts', 'rss', 'archives');

		if (in_array($type, $predefined)) return handles("orchestra/story::{$type}");

		return $this->permalink($type, $content);
	}

	/**
	 * Generate URL by content.
	 *
	 * @param  string  
	 */
	public function permalink($type, $content = null)
	{
		$format = $this->app['config']->get("orchestra/story::permalink.{$type}");
		
		if (is_null($format) or ! ($content instanceof Content)) 
		{
			return handles("orchestra/story::/");
		}

		if (is_null($published = $content->published_at))
		{
			$published = Carbon::now();
		}
		
		$permalinks = array(
			'id'    => $content->id,
			'slug'  => str_replace(array('_post_/', '_page_/'), '', $content->slug),
			'type'  => $content->type,
			'date'  => $published->format('Y-m-d'),
			'year'  => $published->format('Y'),
			'month' => $published->format('m'),
			'day'   => $published->format('d'),
		);

		foreach ($permalinks as $key => $value)
		{
			$format = str_replace('{'.$key.'}', $value, $format);
		}

		return handles("orchestra/story::{$format}");
	}
}
