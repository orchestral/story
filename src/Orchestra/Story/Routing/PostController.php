<?php namespace Orchestra\Story\Routing;

use Illuminate\Support\Facades\View;
use Orchestra\Support\Facades\Facile;
use Orchestra\Story\Model\Content;

class PostController extends ContentController
{
    /**
     * Return the response, this method allow each content type to be group
     * via different set of view.
     *
     * @param  \Orchestra\Story\Model\Content   $page
     * @param  integer                          $id
     * @param  string                           $slug
     * @return Response
     */
    protected function getResponse($page, $id, $slug)
    {
        $slug = preg_replace('/^_post_\//', '', $slug);

        if (! View::exists($view = "orchestra/story::posts.{$slug}")) {
            $view = 'orchestra/story::post';
        }

        $data = array(
            'id'   => $id,
            'page' => $page,
            'slug' => $slug,
        );

        return Facile::view($view)->with($data)->render();
    }

    /**
     * Get the requested page/content from Model.
     *
     * @param  integer  $id
     * @param  string   $slug
     * @return \Orchestra\Story\Model\Content
     */
    protected function getRequestedContent($id, $slug)
    {
        if (isset($id) and ! is_null($id)) {
            return Content::post()->publish()->where('id', $id)->firstOrFail();
        } elseif (isset($slug) and ! is_null($slug)) {
            return Content::post()->publish()->where('slug', "_post_/{$slug}")->firstOrFail();
        }

        return App::abort(404);
    }
}
