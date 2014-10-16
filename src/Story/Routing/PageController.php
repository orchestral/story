<?php namespace Orchestra\Story\Routing;

use Orchestra\Story\Model\Content;
use Illuminate\Support\Facades\View;
use Orchestra\Support\Facades\Facile;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PageController extends ContentController
{
    /**
     * {@inheritdoc}
     */
    protected function getResponse($page, $id, $slug)
    {
        $slug = preg_replace('/^_page_\//', '', $slug);

        if (! View::exists($view = "orchestra/story::pages.{$slug}")) {
            $view = 'orchestra/story::page';
        }

        $data = array(
            'id'   => $id,
            'page' => $page,
            'slug' => $slug,
        );

        return Facile::view($view)->with($data)->render();
    }

    /**
     * {@inheritdoc}
     */
    protected function getRequestedContent($id, $slug)
    {
        if (isset($id) and ! is_null($id)) {
            return Content::page()->publish()->where('id', $id)->firstOrFail();
        } elseif (isset($slug) and ! is_null($slug)) {
            return Content::page()->publish()->where('slug', "_page_/{$slug}")->firstOrFail();
        }

        throw new NotFoundHttpException;
    }
}
