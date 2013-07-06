<?php namespace Orchestra\Story\Routing\Api;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Orchestra\Support\Facades\Messages;
use Orchestra\Support\Facades\Site;
use Orchestra\Story\Model\Content;

class PagesController extends ContentController {

	/**
	 * Define filters for current controller.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->resource = 'storycms.pages';
	}

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

		return View::make('orchestra/story::api.index', compact('contents', 'type'));
	}

	/**
	 * Write a page.
	 *
	 * @access public
	 * @return Response
	 */
	public function create()
	{
		Site::set('title', 'Write a Page');

		$content         = new Content;
		$content->type   = Content::PAGE;
		$content->format = $this->editorFormat;

		return View::make('orchestra/story::api.editor', array(
			'content' => $content,
			'url'     => resources('storycms.pages'),
			'method'  => 'POST',
		));
	}

	/**
	 * Edit a page.
	 *
	 * @access public
	 * @return Response
	 */
	public function edit($id = null)
	{
		Site::set('title', 'Write a Page');

		$content = Content::where('type', 'page')->where('id', $id)->firstOrFail();
		
		return View::make('orchestra/story::api.editor', array(
			'content' => $content,
			'url'     => resources("storycms.pages/{$content->id}"),
			'method'  => 'PUT',
		));
	}

	/**
	 * Store a page.
	 *
	 * @access protected
	 * @return Response
	 */
	protected function storeCallback($content, $input)
	{
		$content->save();

		Messages::add('success', 'Page has been created.');
		return Redirect::to(resources("storycms.pages/{$content->id}/edit"));
	}

	/**
	 * Update a page.
	 *
	 * @access protected
	 * @return Response
	 */
	protected function updateCallback($content, $input)
	{
		$content->save();

		Messages::add('success', 'Page has been updated.');
		return Redirect::to(resources("storycms.pages/{$content->id}/edit"));
	}

	/**
	 * Delete a page.
	 *
	 * @access protected
	 * @return Response
	 */
	protected function destroyCallback($content)
	{
		$content->delete();

		Messages::add('success', 'Page has been deleted.');

		return Redirect::to(resources('storycms.pages'));
	}
}
