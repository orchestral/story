<?php namespace Orchestra\Story\Routing\Api;

use Illuminate\Support\Facades\View;
use Orchestra\Support\Facades\Acl;

class WriterController extends EditorController {

	/**
	 * Define filter for the controller.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$acl = Acl::make('orchestra/story');

		$this->beforeFilter(function () use ($acl)
		{
			if ( ! ($acl->can('create post') or $acl->can('manage post')))
			{
				return resources('/');
			}
		});
	}

	/**
	 * Write a post page.
	 *
	 * @access public
	 * @return Response
	 */
	public function getIndex()
	{
		return View::make('orchestra/story::api.editor');
	}
}
