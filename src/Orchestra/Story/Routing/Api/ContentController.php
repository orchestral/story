<?php namespace Orchestra\Story\Routing\Api;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Orchestra\Support\Facades\App;
use Orchestra\Support\Facades\Site;
use Orchestra\Story\Model\Content;

abstract class ContentController extends EditorController {

	/**
	 * Current Resource.
	 *
	 * @var string
	 */
	protected $resource;

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

	/**
	 * Store a content.
	 *
	 * @access public
	 * @return Response
	 */	
	public function store()
	{
		$input         = Input::all();
		$input['slug'] = $this->generateUniqueSlug($input);
		$validation    = App::make('Orchestra\Story\Services\Validation\Content')
							->on('create')->with($input);

		if ($validation->fails())
		{
			return Redirect::to(resources("{$this->resource}/create"))
					->withInput()->withErrors($validation);
		}

		$content          = new Content;
		$content->title   = $input['title'];
		$content->content = $input['content'];
		$content->slug    = $input['slug'];
		$content->type    = $input['type'];
		$content->format  = $input['format'];
		$content->status  = $input['status'];
		$content->user_id = Auth::user()->id;

		if ($content->status === Content::STATUS_PUBLISH and is_null($content->published_at))
		{
			$content->published_at = Carbon::now();
		}
		
		return call_user_func(array($this, 'storeCallback'), $content, $input);
	}

	/**
	 * Update a content.
	 *
	 * @access public
	 * @return Response
	 */	
	public function update($id = null)
	{
		$input         = Input::all();
		$input['slug'] = $this->generateUniqueSlug($input);
		$validation    = App::make('Orchestra\Story\Services\Validation\Content')
							->on('update')->bind(array('id' => $id))->with($input);

		if ($validation->fails())
		{
			return Redirect::to(resources("{$this->resource}/{$id}/edit"))
					->withInput()->withErrors($validation);
		}

		$content          = Content::findOrFail($id);
		$content->title   = $input['title'];
		$content->content = $input['content'];
		$content->slug    = $input['slug'];
		$content->type    = $input['type'];
		$content->format  = $input['format'];
		$content->status  = $input['status'];

		if ($content->status === Content::STATUS_PUBLISH and is_null($content->published_at))
		{
			$content->published_at = Carbon::now();
		}
		
		return call_user_func(array($this, 'updateCallback'), $content, $input);
	}

	/**
	 * Store a content.
	 *
	 * @abstract
	 * @access protected
	 * @return Response
	 */
	protected abstract function storeCallback($content, $input);

	/**
	 * Update a content.
	 *
	 * @abstract
	 * @access protected
	 * @return Response
	 */
	protected abstract function updateCallback($content, $input);

	/**
	 * Delete a content.
	 *
	 * @access public
	 * @return Response
	 */
	public function delete($id = null)
	{
		return $this->destroy($id);
	}

	/**
	 * Delete a content.
	 *
	 * @access public
	 * @return Response
	 */
	public function destroy($id)
	{
		$content = Content::findOrFail($id);

		return call_user_func(array($this, 'destroyCallback'), $content);
	}

	/**
	 * Delete a content.
	 *
	 * @abstract
	 * @access protected
	 * @return Response
	 */
	protected abstract function destroyCallback($content);

	/**
	 * Generate Unique Slug.
	 *
	 * @access protected
	 * @return string
	 */
	protected function generateUniqueSlug($input)
	{
		return '_'.$input['type'].'_/'.$input['slug'];
	}
}
