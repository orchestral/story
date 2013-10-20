<?php namespace Orchestra\Story\Routing;

use Illuminate\Support\Facades\View;
use Orchestra\Support\Facades\Facile;
use Orchestra\Story\Model\Content;

class PageController extends ContentController
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
        if (! View::exists($view = "orchestra/story::pages.{$slug}")) {
            $view = 'orchestra/story::page';
        }

        return Facile::view($view)->with(array('id' => $id, 'page' => $page))->render();
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
            return Content::page()->publish()->where('id', $id)->firstOrFail();
        } elseif (isset($slug) and ! is_null($slug)) {
            return Content::page()->publish()->where('slug', "_page_/{$slug}")->firstOrFail();
        }

        return App::abort(404);
    }
}
