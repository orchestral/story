<?php namespace Orchestra\Story\Routing;

use Illuminate\Routing\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Orchestra\Support\Facades\Extension;
use Orchestra\Story\Model\Content;

class HomeController extends Controller {

	/**
	 * Get landing page.
	 *
	 * @access public
	 * @return Response
	 */
	public function getIndex()
	{
		$page = Extension::option('orchestra/story', 'default_page', '_posts_');

		if ($page === '_posts_') return $this->showPosts();

		return $this->showDefaultPage($page);
	}

	/**
	 * Show posts.
	 *
	 * @access protected
	 * @return Response
	 */
	protected function showPosts()
	{
		$posts = Content::post()->publish()->paginate(10);

		return View::make('orchestra/story::posts', compact('posts'));
	}

	/**
	 * Show default page.
	 * 
	 * @access protected
	 * @param  string   $page
	 * @return Response
	 */
	protected function showDefaultPage($page)
	{
		$page = Content::page()->publish()->where('slug', '=', $page)->firstOrFail();

		return View::make('orchestra/story::pages', compact('page'));
	}
}
