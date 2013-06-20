<?php namespace Orchestra\Story\Routing;

use Illuminate\Support\Facades\View;
use Orchestra\Story\Model\Content;

class PostController extends ContentController {

	protected function getResponse($page, $id, $slug)
	{
		if ( ! View::exists($view = "orchestra/story::posts.{$slug}"))
		{
			$view = 'orchestra/story::post';
		}

		return View::make($view, compact('page'));
	}

	protected function getRequestedContent($id, $slug)
	{
		switch (true)
		{
			case isset($id) and ! is_null($id) :
				return Content::post()->publish()->where('id', $id)->firstOrFail();
				break;
			case isset($slug) and ! is_null($slug) :
				return Content::post()->publish()->where('slug', $slug)->firstOrFail();
				break;
			default :
				return App::abort(404);
		}
	}
}
