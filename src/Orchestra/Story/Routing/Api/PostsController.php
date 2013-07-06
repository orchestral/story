<?php namespace Orchestra\Story\Routing\Api;

use Illuminate\Support\Facades\View;
use Orchestra\Support\Facades\Site;
use Orchestra\Story\Model\Content;

class PostsController extends EditorController {

	/**
	 * List all the posts.
	 *
	 * @access public
	 * @return Response
	 */
	public function index()
	{
		$contents = Content::with('author')->post()->paginate(30);
		$type     = 'posts';

		Site::set('title', 'List of Posts');

		return View::make('orchestra/story::api.index', compact('contents'));
	}
}
