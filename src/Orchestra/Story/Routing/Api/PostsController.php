<?php namespace Orchestra\Story\Routing\Api;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Orchestra\Support\Facades\Acl;
use Orchestra\Support\Facades\Messages;
use Orchestra\Support\Facades\Site;
use Orchestra\Story\Model\Content;

class PostsController extends ContentController {

	/**
	 * Define filters for current controller.
	 */
	public function __construct()
	{
		parent::__construct();

		$this->resource = 'storycms.posts';

		$this->beforeFilter('orchestra.story:create-post', array(
			'only' => array('create', 'store'),
		));

		$this->beforeFilter('orchestra.story:update-post', array(
			'only' => array('edit', 'update'),
		));

		$this->beforeFilter('orchestra.story:delete-post', array(
			'only' => array('delete', 'destroy'),
		));
	}

	/**
	 * List all the posts.
	 *
	 * @return Response
	 */
	public function index()
	{
		$contents = Content::with('author')->latestBy(Content::CREATED_AT)->post()->paginate(30);
		$type     = 'post';

		Site::set('title', 'List of Posts');
		return View::make('orchestra/story::api.index', compact('contents', 'type'));
	}

	/**
	 * Write a post.
	 *
	 * @return Response
	 */
	public function create()
	{
		Site::set('title', 'Write a Post');

		$content         = new Content;
		$content->type   = Content::POST;
		$content->format = $this->editorFormat;

		return View::make('orchestra/story::api.editor', array(
			'content' => $content,
			'url'     => resources('storycms.posts'),
			'method'  => 'POST',
		));
	}

	/**
	 * Edit a post.
	 *
	 * @return Response
	 */
	public function edit($id = null)
	{
		Site::set('title', 'Write a Post');

		$content = Content::where('type', 'post')->where('id', $id)->firstOrFail();
		
		return View::make('orchestra/story::api.editor', array(
			'content' => $content,
			'url'     => resources("storycms.posts/{$content->id}"),
			'method'  => 'PUT',
		));
	}

	/**
	 * Store a post.
	 *
	 * @return Response
	 */
	protected function storeCallback($content, $input)
	{
		$content->save();

		Messages::add('success', 'Post has been created.');
		return Redirect::to(resources("storycms.posts/{$content->id}/edit"));
	}

	/**
	 * Update a post.
	 *
	 * @return Response
	 */
	protected function updateCallback($content, $input)
	{
		$content->save();

		Messages::add('success', 'Post has been updated.');
		return Redirect::to(resources("storycms.posts/{$content->id}/edit"));
	}

	/**
	 * Delete a post.
	 *
	 * @return Response
	 */
	protected function destroyCallback($content)
	{
		$content->delete();

		Messages::add('success', 'Post has been deleted.');

		return Redirect::to(resources('storycms.posts'));
	}
}
