<?php namespace Orchestra\Story\Routing\Api;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Orchestra\Support\Facades\Acl;
use Orchestra\Support\Facades\Site;
use Orchestra\Story\Model\Content;

class HomeController extends EditorController {

	/**
	 * Define filters for current controller.
	 *
	 * @return void
	 */
	protected function setupFilters() {}

	/**
	 * Show Dashboard.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		$acl = Acl::make('orchestra/story');
		
		if ($acl->can('create post') or $acl->can('manage post'))
		{
			return $this->write();
		}

		return View::make('orchestra/story::api.home');
	}

	/**
	 * Write a post.
	 *
	 * @return Response
	 */
	protected function write()
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
}
