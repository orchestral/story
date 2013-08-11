<?php namespace Orchestra\Story\Routing;

use Illuminate\Routing\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Orchestra\Support\Facades\Facile;
use Orchestra\Story\Model\Content;

class HomeController extends Controller {

	/**
	 * Get landing page.
	 *
	 * @access public
	 * @return Response
	 */
	public function index()
	{
		$page = Config::get('orchestra/story::default_page', '_posts_');

		if ($page === '_posts_') return $this->showPosts();

		return $this->showDefaultPage($page);
	}

	/**
	 * Show posts.
	 *
	 * @access public
	 * @return Response
	 */
	public function showPosts()
	{
		$posts = Content::post()->publish()->paginate(Config::get('orchestra/story::per_page', 10));

		return Facile::view('orchestra/story::posts')->with(compact('posts'))->render();
	}

	/**
	 * Show default page.
	 * 
	 * @access protected
	 * @param  string   $slug
	 * @return Response
	 */
	protected function showDefaultPage($slug)
	{
		$page = Content::page()->publish()->where('slug', '=', $slug)->firstOrFail();
		
		if ( ! View::exists($view = "orchestra/story::pages.{$slug}"))
		{
			$view = 'orchestra/story::page';
		}

		return Facile::view($view)->with(compact('page'))->render();
	}
}
