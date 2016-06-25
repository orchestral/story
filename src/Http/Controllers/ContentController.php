<?php

namespace Orchestra\Story\Http\Controllers;

use Illuminate\Support\Arr;
use Orchestra\Routing\Controller;

abstract class ContentController extends Controller
{
    /**
     * Show the content.
     *
     * @return mixed
     */
    public function show()
    {
        $params = app('router')->current()->parameters();
        $id     = Arr::get($params, 'id');
        $slug   = Arr::get($params, 'slug');

        $page = $this->getRequestedContent($id, $slug);
        $id   = $page->getAttribute('id');
        $slug = $page->getAttribute('slug');

        set_meta('title', $page->getAttribute('title'));

        return $this->getResponse($page, $id, $slug);
    }

    /**
     * Return the response, this method allow each content type to be group
     * via different set of view.
     *
     * @param  \Orchestra\Story\Model\Content  $page
     * @param  int  $id
     * @param  string  $slug
     *
     * @return mixed
     */
    abstract protected function getResponse($page, $id, $slug);

    /**
     * Get the requested page/content from Model.
     *
     * @param  int  $id
     * @param  string  $slug
     *
     * @return \Orchestra\Story\Model\Content
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    abstract protected function getRequestedContent($id, $slug);
}
