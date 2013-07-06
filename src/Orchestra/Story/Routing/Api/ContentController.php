<?php namespace Orchestra\Story\Routing\Api;

use Illuminate\Support\Facades\View;
use Orchestra\Support\Facades\Site;
use Orchestra\Story\Model\Content;

abstract class ContentController extends EditorController {

	/**
	 * List all the contents.
	 *
	 * @abstract
	 * @access public
	 * @return Response
	 */
	public abstract function index();

	/**
	 * Write a content.
	 *
	 * @abstract
	 * @access public
	 * @return Response
	 */
	public abstract function create();

	/**
	 * Edit a content.
	 *
	 * @abstract
	 * @access public
	 * @return Response
	 */
	public abstract function edit($id = null);
}
