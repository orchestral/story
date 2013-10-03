<?php namespace Orchestra\Story\Routing\Api;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Orchestra\Support\Facades\Site;
use Orchestra\Story\Facades\StoryFormat;

abstract class EditorController extends Controller {

	/**
	 * Editor format.
	 *
	 * @var string
	 */
	protected $editorFormat;

	/**
	 * Define filter for the controller.
	 */
	public function __construct()
	{
		$format = StoryFormat::get(Input::get('format'));

		$this->beforeFilter("orchestra.story.editor:{$format}");
		$this->editorFormat = $format;
	}
}
