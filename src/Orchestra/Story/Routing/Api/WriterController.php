<?php namespace Orchestra\Story\Routing\Api;

use Illuminate\Routing\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Orchestra\Story\Facades\StoryFormat;

class WriterController extends Controller {

	/**
	 * Define filter for the controller.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		$format = StoryFormat::get(Input::get('format'));

		$this->beforeFilter("orchestra.story.editor:{$format}");
		View::share('story_format', $format);
	}

	public function getIndex()
	{
		return View::make('orchestra/story::api.editor');
	}
}
