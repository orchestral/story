<?php namespace Orchestra\Story\Routing;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Response;
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
            return $this->posts();
        }

        return $this->page($page);
    }

    /**
     * Show RSS.
     *
     * @return Response
     */
    public function rss()
    {
        $perPage = Config::get('orchestra/story::per_page', 10);
        $posts = Content::post()->latestPublish()->limit($perPage)->get();

        return Response::view('orchestra/story::atom', array('posts' => $posts), 200, array(
            'Content-Type' => 'application/rss+xml; charset=UTF-8',
        ));
    }

    /**
     * Show posts.
     *
     * @return Response
     */
    public function posts()
    {
        $perPage = Config::get('orchestra/story::per_page', 10);
        $posts = Content::post()->latestPublish()->paginate($perPage);

        return Facile::view('orchestra/story::posts')->with(array('posts' => $posts))->render();
    }

    /**
     * Show default page.
     *
     * @param  string   $slug
     * @return Response
     */
    protected function page($slug)
    {
        $page = Content::page()->publish()->where('slug', '=', $slug)->firstOrFail();
        $slug = preg_replace('/^_page_\//', '', $slug);

        if (! View::exists($view = "orchestra/story::pages.{$slug}")) {
            $view = 'orchestra/story::page';
        }

        return Facile::view($view)->with(array('page' => $page))->render();
    }
}
