<?php namespace Orchestra\Story\Routing;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Orchestra\Support\Facades\Facile;
use Orchestra\Story\Model\Content;

class HomeController extends Controller
{
    /**
     * Get landing page.
     *
     * @return Response
     */
    public function index()
    {
        $page = Config::get('orchestra/story::default_page', '_posts_');

        if ($page === '_posts_') {
            return $this->showPosts();
        }

        return $this->showDefaultPage($page);
    }

    /**
     * Show posts.
     *
     * @return Response
     */
    public function showPosts()
    {
        $perPage = Config::get('orchestra/story::per_page', 10);
        $posts   = Content::post()->latestPublish()->paginate($perPage);

        return Facile::view('orchestra/story::posts')->with(array('posts' => $posts))->render();
    }

    /**
     * Show default page.
     *
     * @param  string   $slug
     * @return Response
     */
    protected function showDefaultPage($slug)
    {
        $page = Content::page()->publish()->where('slug', '=', $slug)->firstOrFail();

        if (! View::exists($view = "orchestra/story::pages.{$slug}")) {
            $view = 'orchestra/story::page';
        }

        return Facile::view($view)->with(array('page' => $page))->render();
    }
}
