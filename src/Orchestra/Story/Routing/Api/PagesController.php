<?php namespace Orchestra\Story\Routing\Api;

use Illuminate\Support\Facades\View;
use Orchestra\Support\Facades\Site;
use Orchestra\Story\Model\Content;

class PagesController extends EditorController {

	/**
	 * List all the pages.
	 *
	 * @access public
	 * @return Response
	 */
	public function index()
	{
		$contents = Content::with('author')->page()->paginate(30);
		$type     = 'pages';

		Site::set('title', 'List of Pages');

		return View::make('orchestra/story::api.index', compact('contents'));
	}
}
