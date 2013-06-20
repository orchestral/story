<?php namespace Orchestra\Story\Routing;

use Illuminate\Routing\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Orchestra\Support\Facades\App;
use Orchestra\Support\Facades\Extension;
use Orchestra\Story\Model\Content;

class PageController extends Controller {
	
	public function show($id = null, $slug = null)
	{
		$page = null;

		switch (true)
		{
			case ! is_null($id) :
				$page = Content::page()->publish()->where('id', $id)->firstOrFail();
				break;
			case ! is_null($slug) :
				$page = Content::page()->publish()->where('slug', $slug)->firstOrFail();
				break;
			default :
				return App::abort(404);
		}

		return View::make('orchestra/story::page', compact('page'));
	}
}
