<?php namespace Orchestra\Story\Routing;

use Illuminate\Routing\Controllers\Controller;
use Orchestra\Support\Facades\App;

abstract class ContentController extends Controller {
	
	/**
	 * Show the content.
	 *
	 * @access public
	 * @return Response
	 */
	public function show()
	{
		$params = App::make('router')->getCurrentRoute()->getParameters();
		$id     = isset($params['id']) ? $params['id'] : null;
		$slug   = isset($params['slug']) ? $params['slug'] : null;
		$page   = $this->getRequestedContent($id, $slug);

		return $this->getResponse($page, $id, $slug);
	}

	protected abstract function getResponse($page, $id, $slug);

	protected abstract function getRequestedContent($id, $slug);
}
